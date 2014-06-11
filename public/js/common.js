/**
 * Created by timur on 6/11/14.
 */

var Common = {
    init: function(){
        $( document ).ajaxError(function(event, jqxhr, settings, exception) {
            Common.showMessage("Ошибка в запросе: <br/>" + settings.url)
        });
    },
    showMessage: function (message, important) {
        var options = {};
        if (important) {
            options.header = 'Важно';
        }
        $.jGrowl(message, options);
    }
}

$(function(){
    Common.init();
})


dateFormat = function (datetime) {
    var t = datetime.split(/[- :]/);
    var d = new Date(t[0], parseInt(t[1])-1, t[2], t[3], t[4], t[5]);
    return d.getHours() + ':' + (d.getMinutes()<10?'0':'')+ d.getMinutes();
};
