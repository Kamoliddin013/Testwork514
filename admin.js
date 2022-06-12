document.getElementById("myClearBtn").addEventListener("click", function(){

    document.querySelector('.upload-kamol-image .kamol-rmv').click();
    // let selected_type_prs = document.querySelectorAll('#_select_type_product option');
    var dropDown = document.getElementById("_select_type_product");
    dropDown.selectedIndex = 0;
    document.getElementById('uploaded_image_id_custom').value='';
    document.getElementById("kamol_date_value_id").value = ''

});

(function($){

    jQuery(function ($) {

        // on upload button click
        $('body').on('click', '.kamol-upl', function (e) {

            e.preventDefault();

            var button = $(this),
                custom_uploader = wp.media({
                    title: 'Insert image',
                    library: {
                        // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                        type: 'image'
                    },
                    button: {
                        text: 'Use this image' // button label text
                    },
                    multiple: false
                }).on('select', function () { // it also has "open" and "close" events
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    button.html('<img src="' + attachment.url + '">').next().show().next().val(attachment.id);
                }).open();

        });

        // on remove button click
        $('body').on('click', '.kamol-rmv', function (e) {
            console.log('clicked');

            e.preventDefault();

            var button = $(this);
            button.next().val(''); // emptying the hidden field
            button.hide().prev().html('Upload Custom image to Product');
        });

    });
})(jQuery);