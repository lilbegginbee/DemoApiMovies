/**
 * Created by timur on 6/10/14.
 */

var App = {
    container: null,
    init: function($container) {
        App.container = $container;
        App.cinema.all();
    },
    clean: function() {
        App.container.empty();
    },
    cinema: {
        /**
         * Все киотеатры
         */
        all: function() {
            $.getJSON('/api/cinema/', function(data) {
                App.clean();
                for (index in data.data) {
                    $item = $('<div/>').addClass('col-md-4')
                        .append(
                            $('<div/>').addClass('panel panel-primary')
                                .attr('rel', data.data[index].sysname)
                                .css('cursor','pointer')
                                .append(
                                    $('<div/>').addClass('panel-heading')
                                        .html('<h4>' + data.data[index].title + '</h4>')
                                )
                                .append(
                                    $('<div/>').addClass('panel-body')
                                        .html('<p>' + data.data[index].description + '</p>')
                                )
                                .click(function(){
                                    App.cinema.sheduler($(this).attr('rel'));
                                })
                        );

                    App.container.append($item);
                }
            })
        },
        /**
         * Расписание конкретного кинотеатра
         * @param cinema
         */
        sheduler: function (cinema) {
            $.getJSON('/api/cinema/' + cinema + '/sheduler/', function(data) {
                App.clean();
                console.log(data);
            });
        }
    },
    ticket: {

    }
}

$(function(){
    App.init($('#app'));
})
