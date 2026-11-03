( function ( wp ) {
	const el = wp.element.createElement;
	const Fragment = wp.element.Fragment;
	const registerPlugin = wp.plugins.registerPlugin;
	const PluginDocumentSettingPanel = wp.editPost.PluginDocumentSettingPanel;
	const TextControl = wp.components.TextControl;
	const TextareaControl = wp.components.TextareaControl;
	const SelectControl = wp.components.SelectControl;
	const Button = wp.components.Button;
	const useSelect = wp.data.useSelect;
	const useDispatch = wp.data.useDispatch;

	function useLearningMeta() {
		const meta = useSelect( function ( select ) {
			return select( 'core/editor' ).getEditedPostAttribute( 'meta' ) || {};
		}, [] );
		const editPost = useDispatch( 'core/editor' ).editPost;
		function set( key, value ) {
			editPost( { meta: Object.assign( {}, meta, { [ key ]: value } ) } );
		}
		return { meta: meta, set: set };
	}

	function Field( props ) {
		const Component = props.multiline ? TextareaControl : TextControl;
		return el( Component, {
			label: props.label,
			value: props.value || '',
			onChange: props.onChange,
			rows: props.multiline ? 4 : undefined,
			help: props.help
		} );
	}

	function ListEditor( props ) {
		const values = Array.isArray( props.value ) ? props.value : [];
		return el( Fragment, null,
			values.map( function ( value, index ) {
				return el( 'div', { className: 'learning-resources-repeatable-item', key: index },
					el( Field, { label: props.label + ' ' + ( index + 1 ), value: value, onChange: function ( next ) {
						const copy = values.slice(); copy[ index ] = next; props.onChange( copy );
					} } ),
					el( Button, { variant: 'tertiary', isDestructive: true, onClick: function () {
						props.onChange( values.filter( function ( item, itemIndex ) { return itemIndex !== index; } ) );
					} }, 'Remove' )
				);
			} ),
			el( Button, { variant: 'secondary', onClick: function () { props.onChange( values.concat( [ '' ] ) ); } }, 'Add ' + props.label )
		);
	}

	function ObjectListEditor( props ) {
		const values = Array.isArray( props.value ) ? props.value : [];
		return el( Fragment, null,
			values.map( function ( item, index ) {
				const update = function ( key, value ) {
					const copy = values.map( function ( entry ) { return Object.assign( {}, entry ); } );
					copy[ index ][ key ] = value;
					props.onChange( copy );
				};
				return el( 'div', { className: 'learning-resources-repeatable-item', key: index },
					el( 'h4', null, props.label + ' ' + ( index + 1 ) ),
					props.fields.map( function ( field ) {
						return field.options
							? el( SelectControl, { key: field.key, label: field.label, value: item[ field.key ] || '', options: field.options, onChange: function ( value ) { update( field.key, value ); } } )
							: el( Field, { key: field.key, label: field.label, value: item[ field.key ], multiline: field.multiline, onChange: function ( value ) { update( field.key, value ); } } );
					} ),
					el( Button, { variant: 'tertiary', isDestructive: true, onClick: function () {
						props.onChange( values.filter( function ( entry, itemIndex ) { return itemIndex !== index; } ) );
					} }, 'Remove ' + props.label.toLowerCase() )
				);
			} ),
			el( Button, { variant: 'secondary', onClick: function () {
					const item = {};
					props.fields.forEach( function ( field ) { item[ field.key ] = field.defaultValue || ''; } );
					props.onChange( values.concat( [ item ] ) );
				} }, 'Add ' + props.label )
		);
	}

	function TutorialPanel() {
		const state = useLearningMeta(); const meta = state.meta; const set = state.set;
		return el( PluginDocumentSettingPanel, { name: 'tutorial-details', title: 'Tutorial Details', className: 'learning-resources-tutorial-panel' },
			el( Field, { label: 'Introduction', multiline: true, value: meta._tutorial_intro, onChange: function ( v ) { set( '_tutorial_intro', v ); } } ),
			el( Field, { label: 'Estimated duration (minutes)', value: meta._tutorial_duration, onChange: function ( v ) { set( '_tutorial_duration', parseInt( v, 10 ) || 0 ); } } ),
			el( ListEditor, { label: 'Prerequisite', value: meta._tutorial_prerequisites, onChange: function ( v ) { set( '_tutorial_prerequisites', v ); } } ),
			el( ListEditor, { label: 'Learning outcome', value: meta._tutorial_outcomes, onChange: function ( v ) { set( '_tutorial_outcomes', v ); } } ),
			el( 'h3', null, 'Steps' ),
			el( ObjectListEditor, { label: 'Step', value: meta._tutorial_steps, onChange: function ( v ) { set( '_tutorial_steps', v ); }, fields: [
				{ key: 'title', label: 'Step title' }, { key: 'content', label: 'Instructions', multiline: true }, { key: 'code', label: 'Code example', multiline: true }, { key: 'language', label: 'Code language (e.g. php, javascript)' }
			] } )
		);
	}

	function WorkshopPanel() {
		const state = useLearningMeta(); const meta = state.meta; const set = state.set;
		return el( PluginDocumentSettingPanel, { name: 'workshop-details', title: 'Workshop Details', className: 'learning-resources-workshop-panel' },
			el( Field, { label: 'Facilitator name', value: meta._workshop_facilitator_name, onChange: function ( v ) { set( '_workshop_facilitator_name', v ); } } ),
			el( Field, { label: 'Facilitator biography', multiline: true, value: meta._workshop_facilitator_bio, onChange: function ( v ) { set( '_workshop_facilitator_bio', v ); } } ),
			el( SelectControl, { label: 'Format', value: meta._workshop_format || 'online', options: [ { label: 'Online', value: 'online' }, { label: 'In person', value: 'in_person' }, { label: 'Hybrid', value: 'hybrid' } ], onChange: function ( v ) { set( '_workshop_format', v ); } } ),
			el( Field, { label: 'Venue', value: meta._workshop_venue, onChange: function ( v ) { set( '_workshop_venue', v ); } } ),
			el( 'h3', null, 'Sessions' ),
			el( ObjectListEditor, { label: 'Session', value: meta._workshop_sessions, onChange: function ( v ) { set( '_workshop_sessions', v ); }, fields: [
				{ key: 'title', label: 'Session title' }, { key: 'description', label: 'Description', multiline: true }, { key: 'video_url', label: 'Video / recording URL' }, { key: 'duration_minutes', label: 'Duration (minutes)', defaultValue: 0 }
			] } ),
			el( 'h3', null, 'Materials' ),
			el( ObjectListEditor, { label: 'Material', value: meta._workshop_materials, onChange: function ( v ) { set( '_workshop_materials', v ); }, fields: [
				{ key: 'title', label: 'Material title' }, { key: 'url', label: 'Material URL' }
			] } )
		);
	}

	registerPlugin( 'learning-resources-tutorial-editor', { render: TutorialPanel } );
	registerPlugin( 'learning-resources-workshop-editor', { render: WorkshopPanel } );
} )( window.wp );
