<?php


namespace App\Custom;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class Roles
{
    public static function usersWithRole($role){
        $users = \App\Models\User::where('UserType', 'LIKE', '%"'.$role.'"%')->get();
        return $users;
    }

    public static function createRoles(){
        $roles = \App\Models\Role::ROLES;
        $count = 0;
        foreach( $roles as $role ){
            $created = Role::updateOrCreate(['name' => $role], ['name' => $role]);
            if($created){
                $count += 1;
            }
        }
    }

    public static function RolesToAdmin(){
        $permissions = config('app.permissions');
        $permToDb = [];
        foreach ($permissions as $permissionBlock){
            foreach($permissionBlock as $permission){
                array_push($permToDb, $permission['name']);
            }
        }
        $admin = Role::findByName('admin');
        if($admin){
            $admin->givePermissionTo($permToDb);
        }
    }

    public static function FixPermissions(){
        $permissions = config('app.permissions');
        $permToDb = [];
        foreach ($permissions as $permissionBlock){
            foreach($permissionBlock as $permission){
                //return $permission['name'];
                array_push($permToDb, $permission);
            }
        }
        $permissionFromDb = \App\Models\Permission::all();
        //return $permToDb;
        ;
        $inserted = 0;
        foreach($permToDb as $permission){
            //return $permission;
            //return  $name;
            //return $permission;
            if($permissionFromDb->count()>0){
                if($permissionFromDb->where('name', $permission['name'])->count()==0){
                    \App\Models\Permission::create(['name' => $permission['name'], 'guard_name'=>'web', 'category'=>$permission['category']]);
                    $inserted++;
                }
            }else{
                \App\Models\Permission::create(['name'=> $permission['name'], 'guard_name'=>'web', 'category'=>$permission['category']]);
                $inserted++;
            }
        }
        return $inserted;
    }

    public static function FixRoles(){
        $roles = config('app.user_roles');
        $rolesToDb = [];
        foreach ($roles as $role){
            array_push($rolesToDb, $role);
        }
        $roleFromDb = \App\Models\Role::all();
        $inserted = 0;
        foreach($rolesToDb as $role){
            if($roleFromDb->count()>0){
                if($roleFromDb->where('name', $role)->count()==0){
                    \App\Models\Role::create(['name' => $role, 'guard_name'=>'web']);
                    $inserted++;
                }
            }else{
                \App\Models\Role::create(['name'=> $role, 'guard_name'=>'web']);
                $inserted++;
            }
        }
        return $inserted;
    }

    public static function PermissionToRoles(){
        //permissions for admin
        $permissions = Permission::all();
        $admin = Role::findByName('admin');
        $admin->givePermissionTo($permissions);

        //permissions for hr
        $hr = Role::findByName('hr');
        $hr->givePermissionTo($permissions);
        $hr->revokePermissionTo('update mail settings');
        $hr->revokePermissionTo('create permissions');
        $hr->revokePermissionTo('update permissions');
        $hr->revokePermissionTo('give permissions');
        $hr->revokePermissionTo('revoke permissions');
        $hr->revokePermissionTo('view users');
        $hr->revokePermissionTo('create users');
        $hr->revokePermissionTo('edit users');
        $hr->revokePermissionTo('delete users');


        //permissions for recruiter
        $recruiterPermissions = [];
        $jobPermissions = config('app.permissions.job');
        foreach($jobPermissions as $jobPermission){
            //return $jobPermission;
            array_push($recruiterPermissions, $jobPermission['name']);
        }
        $applicationPermissions =  config('app.permissions.application');
        foreach($applicationPermissions as $applicationPermission){
            array_push($recruiterPermissions, $applicationPermission['name']);
        }
        $recruiter = Role::findByName('recruiter');
        $recruiter->givePermissionTo($recruiterPermissions);
        return true;
    }

    public static function PermissionToJson($user = null){
        $permissions = Permission::all();
        $permitted = [];
        $TOJSON = [];
        if(!is_null($user)){
            $userData = \App\User::find($user);
            $userPerms = $userData->getAllPermission();
            foreach ($userPerms as $userPerm){
                array_push($permitted, $userPerm->name);
            }
        }
        $return = [];
        foreach($permissions as $permission){
            if(in_array($permission->name, $permitted)){
                $selected = true;
            }else{
                $selected = false;
            }
            $perm = [
              'id'=>$permission->id,
              'disabled'=> false,
                'groupName' => $permission->category,
                'groupId'=> $permission->category,
                'selected' => $selected,
                'name' => $permission->name
            ];
            array_push($TOJSON, $perm);
        }
        return $TOJSON;
    }
}
