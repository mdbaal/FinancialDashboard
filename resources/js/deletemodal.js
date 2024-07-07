import jQuery from 'jquery';

jQuery(document).ready(function(){
    jQuery('.modal-close').on('click',function(){
        closeDeleteModal();
    });

    jQuery('.btn-delete').on('click',function(){
        openDeleteModal();
    });
});


function openDeleteModal(){
    jQuery('.modal-background').show();
}

function closeDeleteModal(){
    jQuery('.modal-background').hide();
}
