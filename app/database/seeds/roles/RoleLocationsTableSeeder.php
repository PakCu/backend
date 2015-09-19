<?php

class RoleLocationsTableSeeder extends Seeder {

	public function run()
	{

        $roles = [
            [
                'name' => 'Location Admin'
            ]
        ];

        $permissions = [
            [
                'name' => 'Location:list',
                'display_name' => 'List Locations',
                'group_name' => 'Location'
            ],
            [
                'name' => 'Location:show',
                'display_name' => 'Show Location',
                'group_name' => 'Location'
            ],
            [
                'name' => 'Location:create',
                'display_name' => 'Create New Location',
                'group_name' => 'Location'
            ],
            [
                'name' => 'Location:edit',
                'display_name' => 'Edit Existing Location',
                'group_name' => 'Location'
            ],
            [
                'name' => 'Location:delete',
                'display_name' => 'Delete Existing Location',
                'group_name' => 'Location'
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