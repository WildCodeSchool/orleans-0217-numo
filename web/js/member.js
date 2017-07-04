$(document).ready(function(){

    var list = $(".list .showMember");
    var numToShow = 3;
    var button = $("#next");
    var numInList = list.length;
    list.hide();
    if (numInList > numToShow) {
        button.show();
    }
    list.slice(0, numToShow).show();

    button.click(function(){
        var showing = list.filter(':visible').length;
        list.slice(showing - 1, showing + numToShow).fadeIn();
        var nowShowing = list.filter(':visible').length;
        if (nowShowing >= numInList) {
            button.hide();
        }
    });

});

$('#AlphabetNavAll').click(function(evt){
    $contacts.show();
});

$('.AlphabetNav a').click(function(evt){
    evt.preventDefault();

    var $navItem = $(this),
        $contacts = $('.showMember');


    if ($navItem.hasClass('active')) {
        $navItem.removeClass('active');
    }
        else {
        $contacts.show();
        $('.AlphabetNav a').removeClass('active');
        $navItem.addClass('active');

        $.each($contacts, function(key, contact) {
            var $contact = $(contact),
                $contactName = $contact.find('.memberName'),
                $nameArr = $contactName.text().split(' ');

            if ($nameArr[0].split('')[0].toLowerCase() !== $navItem.text().toLowerCase()) {
                $contact.hide();
            }
        });
    }
});

