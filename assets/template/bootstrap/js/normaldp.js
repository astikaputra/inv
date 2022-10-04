var TempNow = new Date();
var todaydate = new Date(TempNow.getFullYear(), TempNow.getMonth(), TempNow.getDate(), 0, 0, 0, 0);
var checkin = $('#dsr1').datepicker({
  onRender: function(date) {
    return date.valueOf();
  }
}).on('changeDate', function(ev) {
  if (ev.date.valueOf() > checkout.date.valueOf()) {
    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate() + 1);
    checkout.setValue(newDate);
  }
  checkin.hide();
  $('#dsr2')[0].focus();
}).data('datepicker');
var checkout = $('#dsr2').datepicker({
  onRender: function(date) {
   return date.valueOf();
  }
}).on('changeDate', function(ev) {
  checkout.hide();
}).data('datepicker');