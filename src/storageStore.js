import { writable } from 'svelte/store';

const createWritableStore = ( key, startValue ) => {
	const { subscribe, set } = writable( startValue );

	const json = localStorage.getItem( key );
	if ( json ) {
		set( JSON.parse( json ) );
	}

	subscribe( current => {
		localStorage.setItem( key, JSON.stringify( current ) );
	} );

	return {
		subscribe,
		set,
	};
};

export default createWritableStore;
