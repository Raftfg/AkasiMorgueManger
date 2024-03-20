<?php

namespace Modules\Acl\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Acl\Entities\Role;
use Modules\Acl\Entities\Permission;

class RolesAndPermissionsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //'ACL' => ['display' => 'Droit d\'accès', 'action' => 'crud', 'attribuables' => 'super,admin,responsable,agent,proprietaire,locataire'],
        //La clé display permet de fournir le nom de la permission à afficher
        //La clé action permet de déterminer si on applique toutes les actions du CRUD sur cet objet ou pas
        //La clé attribuables permet de déterminer les rôles qui peuvent avoir par défaut les permissions de cet objet
        //

        $objetsPermission = [
            'Revision' => [
                'display' => "audit",
                'groupe' => 'Audit',
                'action' => 'r',
                'attribuables' => [
                    'super' => 'r',
                    'admin' => 'r',
                    'agent' => '',
                ]
            ],
            //Modules ACL
            'Permission' => [
                'display' => "privilège",
                'groupe' => 'Acl',
                'action' => 'r',
                'attribuables' => [
                    'super' => 'r',
                    'admin' => 'r',
                    'agent' => '',
                ]
            ],
            'Role' => [
                'display' => "rôle",
                'groupe' => 'Acl',
                'action' => 'c,r,u,d',
                'attribuables' => [
                    'super' => 'c,r,u,d',
                    'admin' => 'c,r,u,d',
                    'agent' => '',
                ]
            ],
            'User' => [
                'display' => "utilisateur",
                'groupe' => 'Acl',
                'action' => 'c,r,u,d',
                'attribuables' => [
                    'super' => 'c,r,u,d',
                    'admin' => 'c,r,u,d',
                    'agent' => 'c,r,u,d',
                ]
            ],
            
            //Modules Document
            'Document' => [
                'display' => "document",
                'groupe' => 'Document',
                'action' => 'c,r,d',
                'attribuables' => [
                    'super' => 'c,r,d',
                    'admin' => 'c,r,d',
                    'agent' => 'c,r,d',
                ]
            ],
            
            //Modules Notifier
            'NotifierTracking' => [
                'display' => "notification",
                'groupe' => 'Tracking',
                'action' => 'r',
                'attribuables' => [
                    'super' => 'r',
                    'admin' => 'r',
                    'agent' => '',
                ]
            ],

            //Module Comptabilite             
            'Exercice' => [
                'display' => "exercice",
                'groupe' => 'Comptabilite',
                'action' => 'c,r,u,d',
                'attribuables' => [
                    'super' => 'c,r,u,d',
                    'admin' => 'c,r,u,d',
                    'agent' => 'c,r,u,d',
                ]
            ],
            'Devise' => [
                'display' => "devise",
                'groupe' => 'Comptabilite',
                'action' => 'c,r,u,d',
                'attribuables' => [
                    'super' => 'c,r,u,d',
                    'admin' => 'c,r,u,d',
                    'agent' => 'c,r,u,d',
                ]
            ],
            'Journal' => [
                'display' => "journal",
                'groupe' => 'Comptabilite',
                'action' => 'c,r,u,d',
                'attribuables' => [
                    'super' => 'c,r,u,d',
                    'admin' => 'c,r,u,d',
                    'agent' => 'c,r,u,d',
                ]
            ],
            'Ecriture' => [
                'display' => "ecriture",
                'groupe' => 'Comptabilite',
                'action' => 'c,r,u,d',
                'attribuables' => [
                    'super' => 'c,r,u,d',
                    'admin' => 'c,r,u,d',
                    'agent' => 'c,r,u,d',
                ]
            ],
            'Saccount' => [
                'display' => "compte",
                'groupe' => 'Comptabilite',
                'action' => 'c,r,u,d',
                'attribuables' => [
                    'super' => 'c,r,u,d',
                    'admin' => 'c,r,u,d',
                    'agent' => 'c,r,u,d',
                ]
            ],
            'SaccountClass' => [
                'display' => "type de compte",
                'groupe' => 'Comptabilite',
                'action' => 'c,r,u,d',
                'attribuables' => [
                    'super' => 'r',
                    'admin' => 'r',
                    'agent' => 'r',
                ]
            ],

            
            'Budget' => [
                'display' => "budget",
                'groupe' => 'Comptabilite',
                'action' => 'c,r,u,d',
                'attribuables' => [
                    'super' => 'c,r,u,d',
                    'admin' => 'c,r,u,d',
                    'agent' => 'c,r,u,d',
                ]
            ], 
            'Parametre' => [
                'display' => "parametre",
                'groupe' => 'Comptabilite',
                'action' => 'c,r,u,d',
                'attribuables' => [
                    'super' => 'c,r,u,d',
                    'admin' => 'c,r,u,d',
                    'agent' => 'c,r,u,d',
                ]
            ],  
            'Morgue' => [
                'display' => "Morgue", // Nom de l'entité affiché
                'groupe' => 'Comptabilite', // Groupe auquel l'entité appartient
                'action' => 'c,r,u,d', // Actions possibles : créer, lire, mettre à jour, supprimer
                'attribuables' => [
                    'super' => 'c,r,u,d', // Super administrateur : peut créer, lire, mettre à jour, supprimer
                    'admin' => 'c,r,u,d', // Administrateur : peut créer, lire, mettre à jour, supprimer
                    'agent' => 'c,r,u,d', // Agent : peut créer, lire, mettre à jour, supprimer
                ]
            ],          
        ];
        

        $cruds = [
            'c' => ['create' => 'Ajouter'],
            'r' => ['read' => 'Lire'],
            'u' => ['update' => 'Modifier'],
            'd' => ['delete' => 'Supprimer'],
        ];
        /*
          |--------------------------------------------------------------------------
          | Create permissions : CRUD
          |--------------------------------------------------------------------------
         */
        $permissionAgentIds = $permissionAdminIds = [];
        foreach ($objetsPermission as $objet => $objetValue) {
            //Récupérer les actions CRUD possibles sur cet objet
            $objetAction = $objetValue['action'];       //Exemple : 'crud'
            $objetActions = explode(",", $objetAction); //Exemple : ['c','r','u','d']
            //Fabriquer les privilèges
            foreach ($objetActions as $action) {        //Exemple : $action = c
                $crud = $cruds[$action];                //Exemple : ['create' => 'Ajouter'],
                $crudKey = array_keys($crud)[0];       //Exemple : create
                $crudValue = array_values($crud)[0];   //Exemple : Ajouter
                $nomPrivilege = "$crudKey $objet";      //Exemple : create User
                $displayName = $objetValue['display'];  //Exemple : Utilisateur
                $groupe = $objetValue['groupe'];        //Exemple : Acl
                //Créer la permission dans la BD
                $permission = Permission::create([
                            'name' => $nomPrivilege,
                            'display_name' => $crudValue . ' ' . $displayName,
                            'guard_name' => guard_web(),
                            'groupe' => $groupe,
                ]);
                $permission->setTranslation('display_name', 'en', $nomPrivilege);
                $permission->save();

                //Traitons les permissions par défaut pour chaque rôle du tableau
                $permissionAdminIds[] = $permission->id;
                
                $permissionAgentIds[] = $this->getPermissionIdParDefaut($permission, $objetValue, $action, 'agent');
            }
        }
        
        /*
          |--------------------------------------------------------------------------
          | Create roles and assign created permissions. This can be done as separate statements
          |--------------------------------------------------------------------------
         */

        $permissions = Permission::whereIn('id', $permissionAdminIds)->where(['guard_name' => guard_web()])->get();
        $superR = Role::create(['id' => 1, 'name' => 'Super', 'display_name' => 'Super admin', 'guard_name' => guard_web(),]);
        $translations = ['en' => 'Super admin', 'fr' => 'Super admin'];
        $superR->display_name = $translations;
        $superR->save();
        $superR->syncPermissions($permissions);
        
        $adminR = Role::create(['id' => 2, 'name' => 'Admin', 'display_name' => 'Admin', 'guard_name' => guard_web(),]);
        $translations = ['en' => 'Admin', 'fr' => 'Admin'];
        $adminR->display_name = $translations;
        $adminR->save();
        $adminR->syncPermissions($permissions);
        
        $permissions = Permission::whereIn('id', $permissionAgentIds)->where(['guard_name' => guard_web()])->get();
        $AgentR = Role::create(['id' => 3, 'name' => 'Agent', 'display_name' => 'Agent', 'guard_name' => guard_web(),]);
        $translations = ['en' => 'Agent', 'fr' => 'Agent'];
        $AgentR->display_name = $translations;
        $AgentR->save();
        $AgentR->syncPermissions($permissions);

    }

    private function getPermissionIdParDefaut($permission, $objetValue, $action, $role) {
        $attribuables = $objetValue['attribuables'];
        //Si la clé du rôle est définie dans la liste. Exemple :
        //'attribuables' => ['super' => 'r', 'admin' => 'r', 'agent' => 'r',] 
        //Si agent est dans attribuables
        if (isset($attribuables[$role])) {
            $roleAction = $attribuables[$role];             //Exemple : 'crud'
            $roleActions = explode(",", $roleAction);       //Exemple : ['c','r','u','d']
            if (in_array($action, $roleActions)) {            //On peut lui attribuer les permissions par défaut
                return $permission->id;
            }
        }
        return null;
    }
    
}
