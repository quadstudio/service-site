<div class="bg-light p-3 mb-2">
    @lang('site::messages.pagination', [
        'from' => ($pagination->currentpage()-1)*$pagination->perpage()+($pagination->total() > 0 ? 1 : 0),
        'to' => $pagination->currentpage() < $pagination->lastpage() ? $pagination->currentpage()*$pagination->perpage() : $pagination->total(),
        'total' => $pagination->total(),
        'of' => numberof($pagination->total(), 'запис', ['и', 'ей', 'ей'])
        ])
</div>