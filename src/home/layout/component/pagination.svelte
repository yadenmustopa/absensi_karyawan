<script>
    import { createEventDispatcher } from 'svelte';
    import { arrayOfStepNumber } from '../../lib/handle_array';
    import scrollTopPage from '../../lib/scroll_top_page';

    export let data;

    const dispatch = createEventDispatcher();

    let page;
    let offset;
    let per_page;
    let count_all;
    let jumlah_page = 1;
    let numbers     = [];
    let start_page  = 0;
    let end_page    = 0;

    $:if( data ){
        assignTodata();
    }

    function assignTodata()
    {
        page         = data.page;
        per_page     = data.per_page;
        count_all    = data.count_all;
        jumlah_page  = Math.ceil( count_all / per_page );

        generateStartPage();
        generateEndPage();
        console.log({ jumlah_page, start_page, end_page });
    }


    function generateStartPage(){
        if( page <= 3 ){
            start_page = 1;
        }else{
            start_page = page - 2;
        }
    }

    function generateEndPage(){
        if( page >= ( jumlah_page - 2 )){
            end_page = jumlah_page;
        }else{
            end_page = start_page + 2;
        }
    }

    function directPage( pag_page ){
        dispatch('click', { page_to : pag_page });
        scrollTopPage();
    }

</script>
<div class="d-flex justify-content-center pagination mt-4 mb-4">
    { #if count_all }
        { #if page > 1 }
            <button type="button" class="btn btn-round btn-icon m-1" on:click={ () => { directPage( page - 1 ) }}>
                <i class="icon fas fa-arrow-left"></i>
            </button>
        { /if }
        
        { #each arrayOfStepNumber( start_page, end_page ) as pag_page, i }
            <button type="button" class="btn btn-round btn-icon m-1 { ( page === pag_page ) ? 'bg-gradient-info' : 'btn-gradient-wite' }" on:click={ () => { directPage( pag_page ) }}>
                { pag_page }
            </button>
        { /each }

        { #if page < jumlah_page }
            <button type="button" class="btn btn-round btn-icon m-1 " on:click={ () => { directPage( page + 1 ) }}>
                <i class="icon fas fa-arrow-right"></i>
            </button>
        { /if }
    { /if }
</div>