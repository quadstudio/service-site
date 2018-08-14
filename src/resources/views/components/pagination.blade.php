<div class="bg-light p-3">
    @lang('site::messages.pagination', [
        'from' => ($pagination->currentpage()-1)*$pagination->perpage()+1,
        'to' => $pagination->currentpage() < $pagination->lastpage() ? $pagination->currentpage()*$pagination->perpage() : $pagination->total(),
        'total' => $pagination->total(),
        'of' => Site::numberof($pagination->total(), 'запис', array('и', 'ей', 'ей'))
        ])
</div>