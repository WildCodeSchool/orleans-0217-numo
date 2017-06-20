/**
 * Created by wilder9 on 13/06/17.
 */
$(document).ready(function() {
    $('#numobundle_pagecontent_content').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });
});

