<?php

return [
	'extensions' => [
		'type',
		'tokens',
		'utils/url',
		'asset-manager',
		'utils/enums/base',
		'layout/ui/safe-image',
		'layout/pure-component',
		'statemanager/redux/connect',
		'layout/ui/user/empty-avatar',
		'statemanager/redux/slices/users',
	],
	'bundle' => [
		'./src/redux-connect',
		'./src/accent-gradient-enum'
	]
];
