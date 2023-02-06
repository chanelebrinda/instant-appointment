jQuery(document).ready(
    function($) {

        var pending

        //########// Mettre en place le calendrier jQuery //########//

        jQuery('#WR_event_frontend_calandar').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0,
            startDate: '+1d',
            firstDay: 1
        });

        //########// Fonction ajax pour recuperer le maximum de  //########//

        jQuery.ajax({
            type: "POST",
            url : WRservation_admin_client.ajax_url, 
            data : {
                'action' : 'crenaux_simple_participant',
                'event_id' : $("#post-title").attr('title'),
                // 'idDayOfWeek' : $(this).datepicker('getDate').getUTCDay()
            },

            // dataType: 'json',
            cache: false,
            success : function (responses) {
                console.log(responses)
                document.getElementById("WReservation_client_participant").setAttribute("max", parseInt(responses)) 
                document.getElementById("WReservation_maximum_participant").textContent = responses 
            }, 

            error : function(request, error){
                console.log("Error :" + error)
           }
        });

        //########// Enregistrement d'un formulaire pour un évènement à repetition non hebdomadaire //########//

        jQuery("#WReservation_client_simple_submit").click(function (e) {
            e.preventDefault(); //instead of return false
            if(pending) { //there is an ajax request running
               pending.abort();
               return; //do nothing
            }
            pending = jQuery.ajax({
                type: "POST",
                url : WRservation_admin_client.ajax_url, 
                data : {
                    'action' : 'event_simple_reservation',
                    'client_name'   : document.getElementById("WReservation_client_name").value,
                    'client_email'    : document.getElementById("WReservation_client_email").value,
                    'post_event_slug' : $("#post-title").attr('title'),
                    'participant_nb' : document.getElementById("WReservation_client_participant").value
                }, 
                //  dataType: 'json',
                cache: false,
                success : function (response) { 
                    pending = undefined;
                    alert("Nous vous avons envoyez un mail de validation pour cette reservation avec plus de détails ! ")
                    window.location.reload();
                },

                 error : function(request, error){
                     console.log("error :" + error)
                     alert("Nous vous avons envoyez un mail de validation pour cette reservation avec plus de détails ! ")
                     window.location.reload()
                }
            })
        });

        //########// Mise en place d'un formulaire pour un évènement à repetition hebdomadaire //########//

        jQuery("#WR_event_frontend_calandar").on("change",function(){
            var heure
            var date = $(this).val()
            jQuery.ajax({
                type: "POST",
                url : WRservation_admin_client.ajax_url, 
                data : {
                    'action' : 'event_crenaux',
                    'selected_date' : $(this).val(),
                    'event_id' : $("#post-title").attr('title'),
                    'idDayOfWeek' : $(this).datepicker('getDate').getUTCDay()
                },
               
                dataType: 'json',
                cache: false,
                success : function (responses) {
                    console.log(responses[0]["Error"]);
                    var content = document.createElement("div")
                    content.className = "creno_content"
                    if(responses[0]["Error"]!==undefined){
                        var messages_box = document.createElement("span")
                        messages_box.className= "event_error"
                        var messages = document.createTextNode(responses[0]["Error"])
                        messages_box.appendChild(messages)
                        content = messages_box
                        $('.WR_event_notification').text(responses[0]["Error"]);
                    }
                    else{
                        responses.forEach(element => {
                            var creno = document.createElement("input")
                            creno.type = "button"
                            creno.value = element
                            content.appendChild(creno)

                            // Selection d'une date 

                           jQuery(creno).click (function(){
                                // Demander le nombre de participant sur le crénaux 
                                heure = creno.value
                                jQuery.ajax({
                                    type: "POST",
                                    url : WRservation_admin_client.ajax_url, 
                                    data : {
                                        'action' : 'crenaux_participant',
                                        'selected_date' : date,
                                        'event_id' : $("#post-title").attr('title'),
                                        'selected_hour' : heure
                                        // 'idDayOfWeek' : $(this).datepicker('getDate').getUTCDay()
                                    },

                                    // dataType: 'json',
                                    cache: false,
                                    success : function (responses) {
                                        console.log(responses)
                                        document.getElementById("WReservation_client_participant").setAttribute("max", parseInt(responses)) 
                                        document.getElementById("WReservation_maximum_participant").textContent = responses 
                                    }, 

                                    error : function(request, error){
                                        console.log("error :" + error)
                                   }
                                });
                                

                                var select_hour_box = document.createElement("span")
                                var select_hour_box1 = document.createElement("span")
                                var select_hour_box2 = document.createElement("span")
                                select_hour_box1.className = "event_date_time"
                                select_hour_box2.className = "event_date_time"
                       
                                
                                select_hour_box1.textContent = date

                                var select_hour_text = document.createTextNode("Make an appointment on ")
                                select_hour_box.appendChild(select_hour_text)
                                select_hour_box.appendChild(select_hour_box1)
                                select_hour_text = document.createTextNode(" from ")
                                select_hour_box2.textContent = heure 
                                var temp2 =  document.getElementById('current_hour').firstChild
                                select_hour_box.appendChild(select_hour_text)
                                select_hour_box.appendChild(select_hour_box2)

                                document.getElementById("current_hour").replaceChild(select_hour_box, temp2)
                                document.getElementById("WR_select_creno").style.display ="none"
                                document.getElementById("WR_event_frontend_form").style.display ="block"

                                document.getElementById("return_to_crenaux").onclick = function(){
                                    document.getElementById("WR_select_creno").style.display ="grid"
                                    document.getElementById("WR_event_frontend_form").style.display ="none"
                                }
                                
                                //########// Enregistrement d'un formulaire pour un évènement à repetition non hebdomadaire //########//

                                jQuery("#WReservation_client_submit").click(function (e) {
                                    e.preventDefault(); //instead of return false
                                    if(pending) { //there is an ajax request running
                                       pending.abort();
                                       return; //do nothing
                                    }
                                    pending = jQuery.ajax({
                                        type: "POST",
                                        url : WRservation_admin_client.ajax_url, 
                                        data : {
                                            'action' : 'event_reservation',
                                            'client_name'   : document.getElementById("WReservation_client_name").value,
                                            'client_email'    : document.getElementById("WReservation_client_email").value,
                                            'post_event_slug' : $("#post-title").attr('title'),
                                            'begining_date'  :date,
                                            'begining_hour'  : heure,
                                            'participant_nb' : document.getElementById("WReservation_client_participant").value
                                        }, 
                                        //  dataType: 'json',
                                        cache: false,
                                        success : function (response) { 
                                            pending = undefined;
                                            alert("Nous vous avons envoyez un mail de validation pour cette reservation avec plus de détails ! ")
                                            window.location.reload();
                                        },

                                         error : function(request, error){
                                             console.log("error :" + error)
                                             alert("Nous vous avons envoyez un mail de validation pour cette reservation avec plus de détails ! ")
                                             window.location.reload()
                                        }
                                    })
                                });
                           });
                        });   
                    } 

                    var temp =  document.getElementById('WR_select_creno').firstChild
                    var temp0 = document.getElementById('WR_select_creno')
                    temp0.replaceChild(content, temp)
                    
                    temp0.style.display = "grid"
                    document.getElementById('WR_event_frontend_calandar').style.display = "none"

                    document.getElementById("return_to_calandar").onclick = function(){
                        document.getElementById("WR_event_frontend_calandar").style.display ="block"
                        document.getElementById("WR_select_creno").style.display ="none"
                    }

                 } 
             });
        });

    }
);