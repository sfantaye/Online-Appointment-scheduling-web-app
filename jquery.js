$(function() {
    $("#datepicker").datepicker({
      dateFormat: "yy-mm-dd",
      beforeShowDay: function(date) {
        var currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0);
  
        if (date < currentDate) {
          return [false, "past-date"]; 
        }
        return [true, ""];
      }
    });
  });
