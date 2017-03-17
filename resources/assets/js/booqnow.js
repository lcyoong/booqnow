$(function() {
  $('.select2').select2();

  $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
  });

  $('.yearpicker').datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years"
  });

});


// function isJson(str) {
//     try {
//         JSON.parse(str);
//     } catch (e) {
//         return false;
//     }
//     return true;
// }

// function onCompleteNotify(response, el) {
//
//   $(el).prop('disabled', false);
//
//   if (response.data.message) {
//     $.notify(response.data.message, {
//       position: "bottom right",
//       className: "success"
//     });
//   } else {
//     $.notify("Completed without message.", {
//       position: "bottom right",
//       className: "info"
//     });
//   }
//
// }
//
// function onErrorNotify(response, el) {
//
//   $(el).prop('disabled', false);
//
//   if (isJson(response.data.message)) {
//
//     var json = $.parseJSON(response.data.message);
//
//     $.each(json, function(key, value) {
//
//       $.notify(value, {
//         position: "bottom right",
//         className: "error"
//       });
//     });
//   } else {
//     $.notify(response.data.message, {
//       position: "bottom right",
//       className: "error"
//     });
//   }
// }
