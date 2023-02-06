//########// Fonction Ajax pour mettre à jour une reservation  //########//

function update_reservation( id, date, hour , participant_nb, name, email){
    jQuery.ajax({
        type: "POST",
        url : WRservation_admin.ajax_url, 
        data : {
            'action' : 'reservation_update',
            'client_id'   :id,
            'client_name'   :name,
            'client_email'   :email,
            'begining_date'  : document.getElementById(date).value,
            'begining_hour'  : document.getElementById(hour).value,
            'participant_nb' : document.getElementById(participant_nb).value
        }, 
        //  dataType: 'json',
        cache: false,
        success : function (response) { 
            document.getElementById(id).textContent = "Change"
            if (response == 'true')
                 window.location.reload()
            
        },

         error : function(request, error){
             console.log("error :" + error)
         }
    })
 }


 function add_holidays(){
    let date = document.getElementById("holiday_selected").value

    ajax_add_holidays(date)
 }

  //########// Fonction Ajax pour ajouter un jour férié //########//

function ajax_add_holidays(date){
    jQuery.ajax({
        type: "POST",
        url : WRservation_admin.ajax_url, 
        data : {
            'action' : 'holidays_create',
            'date'   : date
        }, 
        //  dataType: 'json',
        cache: false,
        success : function (response) { 
            window.location.reload()   
        },

        error : function(request, error){
             alert("error :" + error)
         }
    })
 }

 //########// Fonction Ajax pour supprimer un jour férié //########//

function delete_holidays(date){
    jQuery.ajax({
        type: "POST",
        url : WRservation_admin.ajax_url, 
        data : {
            'action' : 'holidays_delete',
            'date'   : date
        }, 
        //  dataType: 'json',
        cache: false,
        success : function (response) { 
            window.location.reload()   
        },

        error : function(request, error){
             alert("error :" + error)
         }
    })
 }


//#// Chanfer le texte lors de la modification d'un champs dans la liste des reservation//#//

 function save_change(id) {  
    document.getElementById(id).textContent = "Save Change"
 }

//########// Permet de bloquer des champs lors de la mise à jours des évènements //########//

function change_event_planning(){
    if(document.getElementById("weekly_repeat").checked == true){
        document.getElementById("WR_weekly_planning").style.display = "block"
        document.getElementById("WR_no_weekly_planning").style.display = "none"

        document.getElementById("session_duration").disabled = false
        document.getElementById("time_before_session").disabled = false
        document.getElementById("time_after_session").disabled = false
     }else{
        document.getElementById("WR_weekly_planning").style.display = "none"
        document.getElementById("WR_no_weekly_planning").style.display = "block"

        document.getElementById("session_duration").disabled = true
        document.getElementById("time_before_session").disabled = true
        document.getElementById("time_after_session").disabled = true
     }
}