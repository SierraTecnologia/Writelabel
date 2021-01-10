<?php

namespace WriteLabel\Builders;

use App\Contants\Tables;
use WriteLabel\Entities\UserEntity;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class RoleBuilder.
 *
 * @package WriteLabel\Builders
 */
class RoleBuilder extends Builder
{
    /**
     * @var string
     */
    private $rolesTable = Tables::TABLE_ROLES;

    /**
     * @return $this
     */
    public function whereNameCustomer()
    {
        return $this->where("{$this->rolesTable}.name", UserEntity::ROLE_CUSTOMER);
    }

    /**
     * @return $this
     */
    public function whereNameAdministrator()
    {
        return $this->where("{$this->rolesTable}.name", UserEntity::ROLE_ADMINISTRATOR);
    }
}
