/**
 * Created by wilder9 on 13/06/17.
 */
$(document).ready(function() {
    $('#company_presentationContent').summernote({
/*
        minHeight: 300,
*/
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });
});

