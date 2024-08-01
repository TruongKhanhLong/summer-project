<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Str;
use App\Exceptions\InputException;
use App\Services\Base\ServiceBase;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\TableBase;
use Illuminate\Http\Request;

class RoleTableService extends TableBase
{
    /**
     * Create new order
     *
     * @param array $data
     * @return mixed
     * @throws InputException
     */
    public function createRole(Request $request)
    {
        $data = [
            'id' => $request->input('id'),
            'name' => $request->input('name'),
            'role_level' => $request->input('role_level'),
            'description' => $request->input('description'),
            'options' => $request->input('options'),
        ];
        $newRole = Order::query()->create($data);
        if (!$newRole) {
            throw new InputException("Can't create new role");
        }
        return $data;
    }
    public function updateOrder($role, $request)
    {
        $data = [
            'id' => $request->input('id'),
            'name' => $request->input('name'),
            'role_level' => $request->input('role_level'),
            'description' => $request->input('description'),
            'options' => $request->input('options'),
        ];

        $role->update($data);

        if (!$role) {
            throw new InputException('Role not found');
        }

        return $role;
        
        
    }
    public function deleteRole(array $data)
    {
        return Order::query()->where('id', $data['id'])->delete();
    }
    protected $searchables = [
        'roles.id',
        'roles.name',
    ];

    /**
     * @var string[]
     */
    protected $filterables = [
        'id' => 'roles.id',
        'name' => 'roles.name',

    ];

    /**
     * @var string[]
     */
    protected $orderables = [
        'id' => 'roles.id',
        'name' => 'roles.name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function makeNewQuery()
    {
        return Order::query()
            ->where('company_id', Auth::user()->company_id)
            ->selectRaw($this->getSelectRaw());
    }

    /**
     * Get Select Raw
     *
     * @return string
     */
    protected function getSelectRaw(): string
    {
        $fields = [
            'roles.id',
            'roles.name',
            'roles.role_level',
            'roles.description',
            'roles.options',
        ];

        return implode(', ', $fields);
    }

}