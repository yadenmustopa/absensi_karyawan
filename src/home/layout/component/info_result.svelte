<script>
    "use strict";

    export let count_all;
    export let result_length;
    export let _class;
    export let _label;
</script>

<div class="info-result { _class }">
    <label>{ _label }</label>
    <div class="d-flex justify-content-between info-result-count ">
        <div>Menampilkan :</div>
        <div class="text-right text-bold ">{ result_length } &nbsp; dari &nbsp; { count_all } </div>
    </div>
</div>