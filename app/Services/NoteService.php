<?php
namespace App\Services;

use App\Exceptions\ValidationException;
use App\Repositories\NoteRepository;
use App\User;
use App\Note;
use App\Order;
use Validator;

class NoteService
{

    private $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function create(Order $order, User $user, array $data)
    {

        $note = new Note;
        $note->order = $order->id;
        $note->user = $user->id;
        $note->note = $data['note'];

        $this->noteRepository->save($note);

        return $note;

    }

    public function search($searchKey)
    {

        $matchOrders = $this->noteRepository->getMatch($searchKey);
        $ids = [];

        foreach ($matchOrders as $order) {
            $ids[] = $order['order'];
        }

        return $ids;

    }


    /**
     * Validate and throw ValidationException if data is invalid.
     *
     * @param array $data
     */
    public function validate(array $data)
    {
        $validator = Validator::make($data, [
            'note' => 'required|string|filled|max:750'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

    }

}
