/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 * Created At 13.05.16.
 */

var core = core || {};

core.init = function () {
  this.initMsg();
};

core.initMsg = function () {

  $('a[data-confirm], button[data-confirm], input[type=button][data-confirm]').click(function (e) {
    e.preventDefault();
    var $link = $(this);
    //
    var message = $link.attr('data-confirm') || 'Do you sure to do this action?';
    var link = $link.attr('href');
    if (confirm(message)) {
      location.replace(link);
    }
  });

};

$(function() {
  core.init();
});
