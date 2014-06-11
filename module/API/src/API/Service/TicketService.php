<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 4:03 PM
 */

namespace API\Service;
use API\Model\SessionSeatTable;
use API\Model\TicketTable;
use Hashids\Hashids;

class TicketService
{

    /**
     * @var TicketTable
     */
    protected $ticketTable;

    /**
     * @var SessionSeatTable
     */
    protected $sessionSeatTable;

    /**
     * @todo Почему-то кажется, что конфиг должен быть доступен как-то по-другому
     * @var array
     */
    public $config;

    /**
     * @param TicketTable $ticketTable
     * @param SessionSeatTable $sessionSeatTable
     */
    public function __construct(
                        TicketTable $ticketTable,
                        SessionSeatTable $sessionSeatTable)
    {
        $this->ticketTable = $ticketTable;
        $this->sessionSeatTable = $sessionSeatTable;
    }

    /**
     * Покупка билета на сеанс
     * @param $session int
     * @param $seats array
     * @return array
     * @throws \Exception
     */
    public function buy($session, $seats)
    {
        $seats = preg_split('|,|',$seats);

        $removeEmptyCallback = function($item) {
            $number = trim((int)$item);
            return $number?true:false;
        };

        $seatsValid = array_filter($seats, $removeEmptyCallback );
        if (!count($seatsValid)) {
            throw new \Exception('Отсутствуют номера мест.');
        }

        /**
         * Уникальный короткий код для билетов
         */
        $salt = $this->config['api']['hashids_salt'];
        $hashids = new Hashids($salt);
        $idSession = 1;
        $hash = '';
        // может я не понял, но в качестве аргумента - только набор аргументов. Массив нельзя, строку нельзя,
        // наследоваться тоже нельзя так как Hashids::_encode() private.
        eval( '$hash = $hashids->encrypt('.$idSession.', ' . implode(',',$seatsValid) . ');' );

        // @todo Проверка на конфликты

        $this->ticketTable->insert(
            array(
                'code'          => $hash,
                'id_session'    => $session,
                'created'       => date('Y-m-d H:i:s'),
                'status'        => TicketTable::TICKET_STATUS_ACTIVE
            )
        );

        $idTicket = $this->ticketTable->getLastInsertValue();

        foreach ($seatsValid as $seat) {
            $this->sessionSeatTable->insert(
                array(
                    'id_session' => $session,
                    'id_ticket'  => $idTicket,
                    'seat'       => $seat
                )
            );
        }

        // завершение покупки
        return array(
            'seats' => $seatsValid,
            'code'  => $hash
        );
    }


}