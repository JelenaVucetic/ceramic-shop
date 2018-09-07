/**
 * Created by Ilija_V_ITS on 4/22/2016.
 */

var postId = 0;
var postBodyEllement = null;

$('.post').find('.interaction').find('a:eq(2)').on('click', function(event){
    event.preventDefault();
    postBodyEllement = event.target.parentNode.parentNode.childNodes[1];
    var postBody = postBodyEllement.innerText;
    postId = event.target.parentNode.parentNode.dataset['postid'];
    //console.log(event.target.parentNode.parentNode.dataset['postid']);
    $("#post-body").val(postBody);
    $("#edit-modal").modal();

});

$("#modal-save").on('click', function(){

    $.ajax({
        method: 'POST',
        url: url,
        data: {body:  $("#post-body").val(), postId: postId, _token: token}

    }).done(function(msg){
        $(postBodyEllement).text(msg["new_body"]);
        $("#edit-modal").modal('hide');
    });
});

$(".like").on('click', function(event){
    event.preventDefault();
    var isLike = event.target.previousElementSibling == null;
    postId = event.target.parentNode.parentNode.dataset['postid'];

    $.ajax({
        method: 'POST',
        url: urlLike,
        data: {isLike:  isLike, postId: postId, _token: token}

    }).done(function(msg){

        event.target.innerText = isLike ? event.target.innerText == 'Like' ? 'You liked this post': 'Like' : event.target.innerText == 'Dislike' ? 'You dont like this post' : 'Dislike';

        if(isLike){
            event.target.nextElementSibling.innerText = 'Dislike';
        }
        else{
            event.target.previousElementSibling.innerHTML = 'Like';

        }
    });


});