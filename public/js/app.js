/**
 * Created by timur on 6/10/14.
 */

var App = {
    container: null,
    /**
     * Выбранные места
     */
    seats: new Array(),
    seatsMax: 8,
    idSession: null,
    init: function($container) {
        App.container = $container;
        App.cinema.all();
    },
    clean: function() {
        App.container.empty();
    },
    /**
     * Информация по кинотеатрам
     */
    cinema: {
        /**
         * Все кинотеатры
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
         * Расписание текущего кинотеатра
         * @param cinema string
         */
        sheduler: function (cinema) {
            $.getJSON('/api/cinema/' + cinema + '/sheduler/', function(data) {
                App.clean();
                for (index in data.data.sessions) {
                    $item = $('<div/>').addClass('col-md-4')
                        .append(
                            $('<div/>').addClass('panel panel-primary')
                                .attr('rel', data.data.sessions[index].id_session)
                                .css('cursor','pointer')
                                .append(
                                    $('<div/>').addClass('panel-heading')
                                        .html(
                                            '<h4>Зал №' + data.data.sessions[index].id_hall + '</h4>' +
                                            '<b>' + dateFormat(data.data.sessions[index].start_date) + '</b>'
                                        )
                                )
                                .append(
                                    $('<div/>').addClass('panel-body')
                                        .html('<p>' + data.data.movies[data.data.sessions[index].id_movie].title + '</p>')
                                )
                                .click(function(){
                                    App.session.seats($(this).attr('rel'));
                                })
                        );
                    App.container.append($item);
                }

                if (!data.data.sessions.length) {
                    App.container.append($('<p/>').text('Сеансов нет.'));
                }
            });
        }

    },
    /**
     * Сеансы
     */
    session: {
        seats: function(session) {
            App.idSession = session;
            $.getJSON('/api/cinema/seats/' + session, function(data) {
                App.clean();
                // Рисуем места
                var qty = parseInt(data.seats) + 1
                for (index=1; index < qty; index++) {
                    $item = $('<a/>')
                        .attr('href','#')
                        .attr('rel',index)
                        .addClass('hallSeat')
                        .text(index)
                        /**
                         *  Выбор нужного места
                         */
                        .click(
                            function(){
                                if (!$(this).hasClass('choosen')) {

                                    if (App.seats.length == App.seatsMax) {
                                        Common.showMessage('Нельзя покупать/бронировать сразу больше ' + App.seatsMax + ' мест');
                                        return false;
                                    }

                                    $(this).addClass('choosen');
                                    App.seats.push($(this).attr('rel'));
                                } else {
                                    $(this).removeClass('choosen');
                                    var rIndex = App.seats.indexOf($(this).attr('rel'));
                                    if (rIndex > -1) {
                                        App.seats.splice(rIndex,1);
                                    }
                                }

                                App.session.refreshActions();

                                return false;
                            }
                        );
                    App.container.append($item);
                }

                var $butBuy = $('<button/>')
                                    .addClass('btn btn-primary disabled')
                                    .text('Купить')
                                    .attr('id','butBuy')
                                    .click(function(){
                                        App.ticket.buy();
                                    });
                var $butCancel = $('<button/>')
                                    .addClass('btn btn-danger disabled')
                                    .text('Отменить')
                                    .attr('id','butCancel')
                                    .click(function(){
                                        App.seats = new Array();
                                        $('.choosen',App.container).removeClass('choosen');
                                        App.session.refreshActions();
                                    });
                App.container.append(
                                $('<div/>')
                                    .addClass('well')
                                    .append(
                                        $('<div/>')
                                            .addClass('btn-group')
                                            .append($butBuy,$butCancel)
                                    )

                    );

            });
        },
        refreshActions: function() {
            if (App.seats.length) {
                $('#butBuy').removeClass('disabled');
                $('#butCancel').removeClass('disabled');
            } else {
                $('#butBuy').addClass('disabled');
                $('#butCancel').addClass('disabled');
            }
        }
    },
    /**
     * Покупка/Возврат билетов
     */
    ticket: {
        buy: function() {
            $.getJSON('/api/ticket/buy/' + App.idSession + '/' + App.seats.join(','), function(data) {
                //App.session.seats(App.session);
                App.ticket.show(data);
            });
        },
        /**
         * Показать купленный билет/бронь
         */
        show: function(data) {
            App.clean();
        }
    }
}

$(function(){
    App.init($('#app'));
})
