$(document).ready(function () {
    checkitem();
	$('#carouselNewsIndicators .carousel-control-prev').hide();
});

$('#carouselNewsIndicators').on('slid.bs.carousel', checkitem);

function checkitem()
{
    var $this = $('#carouselNewsIndicators');
    if ($(this).find('.carousel-item:first').hasClass('active')) {
        $this.children('.carousel-control-prev.outside').hide();
        $this.children('.carousel-control-next.outside').show();
    } else if ($(this).find('.carousel-item:last').hasClass('active')) {
        $this.children('.carousel-control-prev.outside').show();
        $this.children('.carousel-control-next.outside').hide();
    } else {
        $this.children('.carousel-control-prev.outside').show();
        $this.children('.carousel-control-next.outside').show();
    }
}