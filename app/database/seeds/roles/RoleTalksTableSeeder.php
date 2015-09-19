<?php

class RoleTalksTableSeeder extends Seeder {

	public function run()
	{

        $roles = [
            [
                'name' => 'Talk Admin'
            ]
        ];

        $permissions = [
            [
                'name' => 'Talk:list',
                'display_name' => 'List Talks',
                'group_name' => 'Talk'
            ],
            [
                'name' => 'Talk:show',
                'display_name' => 'Show Talk',
                'group_name' => 'Talk'
            ],
            [
                'name' => 'Talk:create',
                'display_name' => 'Create New Talk',
                'group_name' => 'Talk'
            ],
            [
                'name' => 'Talk:edit',
                'display_name' => 'Edit Existing Talk',
                'group_name' => 'Talk'
            ],
            [
                'name' => 'Talk:delete',
                'display_name' => 'Delete Existing Talk',
                'group_name' => 'Talk'
            ]
        ];
        
        $createdPermissions = [];

        foreach($permissions as $permission)
        {
            $created = Permission::create($permission);
            $createdPermissions[] = $created->id;
        }

        foreach($roles as $role)
        {
            $created = Role::create($role);
            $created->perms()->sync($createdPermissions);
        }
     }

}