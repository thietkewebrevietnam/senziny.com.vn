(function($){
    window.VcBackendTIsTabsView = window.VcBackendTtaTabsView.extend( {
        addSection: function ( prepend ) {
            var newTabTitle, params, shortcode;

            newTabTitle = this.defaultSectionTitle;
            params = {
                shortcode: 'is_tab',
                params: { title: newTabTitle },
                parent_id: this.model.get( 'id' ),
                order: (_.isBoolean( prepend ) && prepend ? vc.add_element_block_view.getFirstPositionIndex() : vc.shortcodes.getNextOrder()),
                prepend: prepend // used in notifySectionRendered to create in correct place tab
            };
            shortcode = vc.shortcodes.create( params );

            return shortcode;
        },
    } );
})(window.jQuery)