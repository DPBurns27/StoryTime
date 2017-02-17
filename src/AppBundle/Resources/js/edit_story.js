/**
 * Created by David on 17/2/17.
 */
//
// $('document').submit(function (event){
//     event.preventDefault();
//     window.alert("js hit");
//     $.post($(this).attr('action'),
//         {data: $(this).serialize()},
//         function(response){
//             if(response.code == 100 && response.success){//dummy check
//                 $('square-text').html('worked!');
//             }
//
//         }, "json");
// })

function addWord () {
    // window.alert(document.getElementById('next_word').value);
    event.preventDefault();
    $.post($(this).attr('action'),
        {next_word: document.getElementById('next_word').value},
        function(response){
            if(response.code == 100 && response.success){
                $('#square_text').html(response.body);
                //document.getElementById('next_word').value = "";
                $('#next_word').val("");
            }

        }, "json");
}