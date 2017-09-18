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
    var data = JSON.parse(response.data)
    if (data.message) {
      $.notify(data.message, {
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
    var data = JSON.parse(response.data)
    if (util.isJson(data.message)) {

      var json = $.parseJSON(data.message);

      $.each(json, function(key, value) {

        $.notify(value, {
          position: "bottom right",
          className: "error"
        });
      });
    } else {
      $.notify(data.message, {
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
