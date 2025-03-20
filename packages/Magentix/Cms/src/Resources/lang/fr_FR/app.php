<?php

return [
    'acl' => [
        'cms'    => 'CMS',
        'pages'  => 'Pages',
        'create' => 'Ajouter',
        'edit'   => 'Modifier',
        'delete' => 'Supprimer',
    ],
    'exporters' => [
        'page' => [
            'title' => 'Pages',
        ],
    ],
    'cms' => [
        'pages' => [
            'index' => [
                'title' => 'Pages',
                'add'   => 'Ajouter une page',
                'grid'  => [
                    'id'         => 'ID',
                    'group'      => 'Groupe',
                    'code'       => 'Code',
                    'slug'       => 'Slug',
                    'title'      => 'Titre',
                    'locale'     => 'Langue',
                    'created_at' => 'Créé le',
                    'status'     => 'Statut',
                    'edit'       => 'Modifier',
                    'delete'     => 'Supprimer',
                ],
            ],
            'edit' => [
                'title' => 'Modifier la page',
            ],
            'create' => [
                'title' => 'Nouvelle page',
            ],
            'form' => [
                'group'      => 'Groupe',
                'new-group'  => 'Nouveau groupe',
                'code'       => 'Code',
                'slug'       => 'Slug',
                'title'      => 'Titre',
                'locale'     => 'Langue',
                'content'    => 'Contenu',
                'status'     => 'Statut',
                'header'     => [
                    'title'    => 'Page',
                    'back-btn' => 'Retour',
                    'save-btn' => 'Enregistrer la page',
                ],
            ],
            'not-found'      => 'La page avec le code ":code" est introuvable',
            'update-success' => 'Page modifiée avec succès',
            'create-success' => 'Page crée avec succès',
            'delete-success' => 'Page suprimée avec succès',
            'disabled'       => 'Désactivé',
            'enabled'        => 'Activé',
        ],
    ],
];
