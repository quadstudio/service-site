<?php

namespace QuadStudio\Service\Site\Mail\Guest;

use DOMDocument;
use DOMElement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class MailingHtmlEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var array
     */
    public $files;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $content;
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    public $unsubscribe;


    /**
     * Create a new message instance.
     * @param $unsubscribe
     * @param $title
     * @param $content
     * @param array $files
     */
    public function __construct($unsubscribe, $title, $content, array $files= [])
    {
        $this->files = $files;
        $this->title = $title;
        $this->content = $content;
        $this->unsubscribe = $unsubscribe;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject($this->title)
            ->view('site::admin.mailing.html')
            ->embedFiles()
            ->embedImages()
            ->embedUnsubscribe();

    }

    /**
     * @return $this
     */
    private function embedUnsubscribe()
    {
        $this->withSwiftMessage(function (\Swift_Message $message) {


            $headers = $message->getHeaders();

            $headers->addTextHeader('List-Unsubscribe', "<{$this->unsubscribe}>");
            $headers->addTextHeader('Precedence', 'bulk');
        });

        return $this;
    }

    /**
     * @return $this
     */
    private function embedImages()
    {
        $html = new DOMDocument();
        $html->loadHTML($this->content);
        $images = $html->getElementsByTagName('img');

        if ($images->length > 0) {

            $swift_images = [];

            /** @var DOMElement $image */
            foreach ($images as $image) {

                $src = $image->getAttribute('src');

                if (substr($src, 0, 5) == 'data:') {

                    $name = $image->getAttribute('data-filename');
                    $info = getimagesize($src);
                    $mime = $info['mime'];

                    $cid = \Swift_DependencyContainer::getInstance()
                        ->lookup('mime.idgenerator')
                        ->generateId();

                    $data = preg_replace('#^data:image/\w+;base64,#i', '', $src);
                    $swift_images[$cid] = new \Swift_Image(base64_decode($data), $name, $mime);
                    $this->content = str_replace($src, "cid:{$cid}", $this->content);
                }
            }
            $this->withSwiftMessage(function (\Swift_Message $message) use ($swift_images) {

                if (!empty($swift_images)) {
                    foreach ($swift_images as $cid => $image) {
                        $message->embed($image->setId($cid));
                    }
                }
            });
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function embedFiles()
    {
        if (count($this->files) > 0) {
            foreach ($this->files as $file) {
                $this->attach($file['file'], $file['options']);
            }
        }

        return $this;
    }

}
