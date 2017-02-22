module.exports = {

  isJson: function (str) {
      try {
          JSON.parse(str);
      } catch (e) {
          return false;
      }
      return true;
  },

  onCompleteNotify: function (response) {

    // $(el).prop('disabled', false);

    if (response.data.message) {
      $.notify(response.data.message, {
        position: "bottom right",
        className: "success"
      });
    } else {
      $.notify("Completed without message.", {
        position: "bottom right",
        className: "info"
      });
    }

  },

  onErrorNotify: function (response) {

    // $(el).prop('disabled', false);

    if (util.isJson(response.data.message)) {

      var json = $.parseJSON(response.data.message);

      $.each(json, function(key, value) {

        $.notify(value, {
          position: "bottom right",
          className: "error"
        });
      });
    } else {
      $.notify(response.data.message, {
        position: "bottom right",
        className: "error"
      });
    }
  },

  showModal: function (path) {

    $('#basicModal').find('.modal-content').html('');
    $('#basicModal').modal('show');
    $('#basicModal').find('.modal-content').load(path);
    
  }


};
