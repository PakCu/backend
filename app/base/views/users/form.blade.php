{{Former::text('user')
    ->label('Name')
    ->required()}}
{{Former::text('username')
    ->label('Username')
    ->required()}}
{{Former::text('mobile_number')
    ->label('Mobile Number')
    ->help('0192727155')
    ->required()}}
{{Former::email('email')
    ->required()}}
{{Former::multiselect('roles')
    ->label('Roles')
    ->options(Role::all()->lists('name', 'id'), (isset($user) ? $user->roles->lists('id') : [])) }}
