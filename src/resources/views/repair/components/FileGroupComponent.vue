<template>
    <div class="row">
        <div class="col">
            <fieldset class="border p-3 mb-1">
                <h5>{{title}}</h5>
                <form method="POST" enctype="multipart/form-data" :action="action">
                    <input type="hidden" name="_token" :value="csrf">
                </form>
            </fieldset>
        </div>
    </div>
</template>
<script>

</script>
<style>

</style>