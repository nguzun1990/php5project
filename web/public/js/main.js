
confirmDeleteMsg = "Supprimer l'annonce ?";
confirmDeletesMsg = "Supprimer les annonces ?";
errorDeleteMsg = "La suppression de l' annonce a échoué";
noAdvertsSelectedMessage = "Pas d'annonces sélectionnées";

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#photo-div')
            .attr('src', e.target.result)
            .width(150)
            .height(200);
        };

        reader.readAsDataURL(input.files[0]);
    }
}


function deleteAdvert(advertId){
    $('body').append("<div id='dialog-my-confirmation' class='dialog-my-confirmation' title='Confirmer'><p>" + confirmDeleteMsg + "</p></div>");

    $(function() {
        $( "#dialog-my-confirmation" ).dialog({
            resizable: false,
            modal: true,
            buttons: {
                "Oui": function() {
                    blockScreen();
                    deleteAdvertUrl = deleteAdvertLink.replace('advertId',advertId);
                    $.ajax({
                        type: 'GET',
                        url: deleteAdvertUrl
                    }).done(function(response) {
                        unblockScreen();
                        if (response == 'success') {
                            searchAdverts();
                        } else {
                            searchAdverts();
                            $('body').append("<div id='dialog-my-alert' class='dialog-my-alert' title='Alert'>  <p>" + errorDeleteMsg + "</p></div>");
                            $( "#dialog-my-alert" ).dialog();
                        }
                    });
                    $( this ).dialog( "close" );

                },
                "Non": function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                $('.dialog-my-confirmation').remove();
                $( '.dialog-my-alert' ).remove();
            }
        });
    });
}


function deleteAdverts() {
    $('body').append("<div id='dialog-my-confirmation' class='dialog-my-confirmation' title='Confirmer'><p>" + confirmDeletesMsg + "</p></div>");
    i = 0;
    adverts = [];
    $(".advert-check-td input[type=checkbox]:checked").each(function()
    {
        adverts[i] = $(this).val();
        i++;
    });
    if (i === 0) {
        showAlert(noAdvertsSelectedMessage);

        return;
    }
    $(function() {
        var adverts = [];
        $( "#dialog-my-confirmation" ).dialog({
            resizable: false,
            modal: true,
            buttons: {
                "Oui": function() {
                    blockScreen();
                    i = 0;
                    $(".advert-check-td input[type=checkbox]:checked").each(function()
                    {
                        adverts[i] = $(this).val();
                        i++;
                    });

                    deleteAdvertsUrl = deleteAdvertsLink;
                    $.ajax({
                        type: 'POST',
                        data: {
                            adverts: adverts
                        },
                        url: deleteAdvertsUrl
                    }).done(function(response) {
                        unblockScreen();
                        if (response == 'success') {
                            searchAdverts();
                        } else {
                            searchAdverts();
                            showAlert(errorDeleteMsg);
                        }
                    });
                    $( this ).dialog( 'close' );
                },
                "Non": function() {
                    $( this ).dialog( 'close' );
                }
            },
            close: function() {
                $('.dialog-my-confirmation').remove();
                $('.dialog-my-alert').remove();
            }
        });
    });
}

function showSearchForm() {
    $('span#search-advert-input').show();
}

function closeSearchForm() {
    $('span#search-advert-input').hide();
    $('span#search-advert-input input[type=text]').val('');
}

function reloadAdvertList() {
    blockScreen();
    listContentAdvertUrl = listContentAdvertLink;
    $.ajax({
        type: "GET",
        url: listContentAdvertUrl
    }).done(function(response) {
        $('#list-adverts-container').html(response);
        unblockScreen();
    });
}


function searchAdverts() {
    sentence = $('#search-advert-input input[type=text]').val();
    blockScreen();
    searchUrl = searchLink;
    $.ajax({
        type: "POST",
        data: {
            sentence: sentence
        },
        url: searchUrl
    }).done(function(response) {
        $('#list-adverts-container').html(response);
        unblockScreen();
    });
}

var timeout = null;
function doDelayedSearch() {
    if (timeout) {
        clearTimeout(timeout);
    }
    timeout = setTimeout(function() {
        searchAdverts();
    }, 650);
}

//block screen for client
function blockScreen() {
    $("body").append('<img class="loading-block for-loading-hide" src="/public/css/images/loading.gif" alt="" />');
    $("body").addClass("balck_background");
}

//unblock screen for client
function unblockScreen() {
    $("body").removeClass('balck_background');
    $('.for-loading-hide').remove();
}

function showAlert(message) {
    $('body').append("<div id='dialog-my-alert' class='dialog-my-alert' title='Alert'>  <p>" + message + "</p></div>");
    $('#dialog-my-alert').dialog({
        resizable: false,
        modal: true,
        close: function() {
            $('.dialog-my-alert').remove();
        }
    });
    $('#dialog-my-alert').dialog( "open" );
}

function resizeHomePage() {
    var advertHeight1 = $('.advert-summary-1').height();
    var advertHeight2 = $('.advert-summary-2').height();
    var advertHeight3 = $('.advert-summary-3').height();
    var advertHeight4 = $('.advert-summary-4').height();
    var advertHeight5 = $('.advert-summary-5').height();
    if (advertHeight1 > advertHeight2 + advertHeight3) {
        var advertImgHeight3 = $('.advert-summary-3 .advert-summary-image img').height();
        advertContHeight3  = advertHeight1 - advertHeight2 - advertImgHeight3;
        $('.advert-summary-3 .advert-summary-content').height(advertContHeight3 - 20);
    }
    if ((advertHeight2 + advertHeight3) > (advertHeight4 + advertHeight5)) {
        advertHeight4 = advertHeight2 + advertHeight3 - advertHeight5;
        $('.advert-summary-4').height(advertHeight4);
    } else {
        var advertImgHeight3 = $('.advert-summary-3 .advert-summary-image img').height();
        advertContHeight3  = advertHeight4 + advertHeight5 - advertHeight2 - advertImgHeight3 ;
        $('.advert-summary-3 .advert-summary-content').height(advertContHeight3 - 20);
    }

}

function openWindowDetail(href, title) {
    window.open(href, "'" + title + "'", 'titlebar=no,toolbar=no,location=no,status=no,scrollbars=yes,menubar=no,width=700,height=550');

    return false;
}


$(function() {
    $('#search-advert-input input[type=text]').keyup(function() {
        doDelayedSearch();
    });
    $( window ).resize(function() {
        resizeHomePage();
    });
});