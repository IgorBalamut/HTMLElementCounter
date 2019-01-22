$(document).ready(function(){
	
	/* attach a submit handler to the form */
	$("#input_form").submit(function(event) {

	/* stop form from submitting */
	event.preventDefault();

	/* get the action attribute */
	var $form = $( this ),
	url = $form.attr( 'action' );

	data = {input_url: $form.find('input[name="input_url"]').val(),
			input_element: $form.find('input[name="input_element"]').val()};

	/* send the data using post request */
	$.ajax({
        type: "post",
            url: url,
            data: data,
            dataType: "json",
            contentType: "application/x-www-form-urlencoded",
            success: function(data, textStatus, jqXHR) {
                console.log(data);
            if(data.status == 'success') {    
                $('.output_url').text(data.output_url);
                $('.output_element').text(data.output_element);
                $('.output_domain').text(data.output_domain);
                $('.output_time').text(data.output_time);
                $('.output_period').text(data.output_duration);
                $('.output_count').text(data.output_count);
                $('.stat_count_url').text(data.stat_count_url);
                $('.stat_average_time').text(data.stat_average_time);
                $('.stat_element_domain').text(data.stat_element_domain);
                $('.stat_total_element').text(data.stat_total_element);
                } else { 
                    openModal(data.Error);       
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 console.log(textStatus);
            }
        })

	});

    // outside click to close modal
   $(window).click(function(e) {
        if(e.target.id == 'modal') {
         $('#modal').css("display", "none");
        }
    });

    // button click to close modal
    $(".close-btn").click(function(){
         $('#modal').css("display", "none");
    });

    // open modal window
    function openModal(textMessage) {
         $('#modal-text').text(textMessage);
         $('#modal').css("display", "block");
    }

    // close modal window
    function closeModal() {
         $('#modal').css("display", "none");
    }

});