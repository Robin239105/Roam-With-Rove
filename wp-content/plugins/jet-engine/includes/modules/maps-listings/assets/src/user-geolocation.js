const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;

const {
	SVG,
	Path
} = wp.primitives;

const {
	InspectorControls
} = wp.editor;

const {
	PanelBody,
	SelectControl,
	Disabled,
	TextControl
} = wp.components;

const {
	serverSideRender: ServerSideRender
} = wp;

const Icon = <SVG width="24" height="24" viewBox="0 0 45 41" fill="none" xmlns="http://www.w3.org/2000/svg"><Path fillRule="evenodd" clipRule="evenodd" d="M34.5167 19.475C32.2854 19.475 30.475 21.2854 30.475 23.5167C30.475 25.748 32.2854 27.5583 34.5167 27.5583C36.748 27.5583 38.5583 25.748 38.5583 23.5167C38.5583 21.2854 36.748 19.475 34.5167 19.475ZM32.475 23.5167C32.475 22.39 33.39 21.475 34.5167 21.475C35.6434 21.475 36.5583 22.39 36.5583 23.5167C36.5583 24.6434 35.6434 25.5583 34.5167 25.5583C33.39 25.5583 32.475 24.6434 32.475 23.5167Z" fill="currentColor"/><Path fillRule="evenodd" clipRule="evenodd" d="M20.0357 21.6545C20.9196 21.3636 21.7176 20.903 22.4297 20.2727C23.1663 19.6424 23.7924 18.903 24.308 18.0545C24.8237 17.2061 25.2165 16.3091 25.4866 15.3636C25.7813 14.4182 25.9286 13.4848 25.9286 12.5636V7.98182C25.9286 6.57576 25.4252 5.37576 24.4185 4.38182C23.4364 3.36364 22.2455 2.81818 20.846 2.74545L20.0725 1.25455C19.8025 0.745455 19.385 0.381818 18.8203 0.163636C18.2801 -0.0545454 17.7277 -0.0545454 17.1629 0.163636L10.6808 2.70909C9.67411 3.12121 8.81473 3.83636 8.10268 4.85455C7.41518 5.87273 7.07143 6.91515 7.07143 7.98182V12.5636C7.07143 13.4606 7.20647 14.3818 7.47656 15.3273C7.77121 16.2727 8.17634 17.1697 8.69197 18.0182C9.20759 18.8424 9.82143 19.5818 10.5335 20.2364C11.2701 20.8667 12.0804 21.3273 12.9643 21.6182C12.9643 22.2 12.8783 22.8303 12.7065 23.5091C12.5346 24.1636 11.9699 24.5636 11.0123 24.7091L3.79353 25.9818C2.68862 26.2 1.78013 26.7455 1.06808 27.6182C0.356027 28.4667 0 29.4485 0 30.5636V35.8364C0 36.1515 0.110491 36.4182 0.331473 36.6364C0.577009 36.8788 0.859375 37 1.17857 37H31.3149C31.7121 37.5202 32.0828 37.9879 32.4095 38.3904C32.8156 38.8908 33.1546 39.2916 33.3931 39.5684C33.5124 39.7068 33.6066 39.8144 33.6715 39.8879C33.704 39.9247 33.7292 39.9529 33.7465 39.9724L33.7666 39.9948L33.7721 40.0009L33.7737 40.0027C33.7739 40.0029 33.7746 40.0036 34.5167 39.3333L33.7746 40.0036L34.5167 40.8252L35.2588 40.0036L34.5167 39.3333C35.2588 40.0036 35.2586 40.0038 35.2588 40.0036L35.2596 40.0027L35.2667 39.9948L35.2868 39.9724C35.3042 39.9529 35.3293 39.9247 35.3618 39.8879C35.4268 39.8144 35.521 39.7068 35.6402 39.5684C35.8787 39.2916 36.2178 38.8908 36.6239 38.3904C37.4352 37.3907 38.5186 35.9883 39.604 34.3796C40.6874 32.7738 41.7852 30.9442 42.6152 29.0916C43.4393 27.2521 44.0333 25.3159 44.0333 23.5167C44.0333 18.2559 39.7775 14 34.5167 14C29.2559 14 25 18.2559 25 23.5167C25 24.0907 25.0605 24.6786 25.1696 25.273L21.9877 24.7091C21.0301 24.5636 20.4654 24.1636 20.2935 23.5091C20.1217 22.8545 20.0357 22.2364 20.0357 21.6545ZM25.7448 27.4061L21.6605 26.6823C20.3184 26.472 18.8162 25.7579 18.3591 24.017C18.1506 23.223 18.0357 22.433 18.0357 21.6545V20.2072L19.4105 19.7548C20.0303 19.5508 20.5911 19.2292 21.1041 18.7752L21.1166 18.764L21.1294 18.7531C21.7012 18.2638 22.1905 17.6879 22.5989 17.0159C23.0226 16.3187 23.343 15.5861 23.5635 14.8143L23.5701 14.7913L23.5772 14.7686C23.8163 14.0013 23.9286 13.2685 23.9286 12.5636V7.98182C23.9286 7.1143 23.6421 6.42578 23.0134 5.80502L22.996 5.78788L22.9791 5.77033C22.3452 5.1132 21.6302 4.7889 20.7422 4.74276L19.5982 4.68331L18.3027 2.18607C18.2712 2.1278 18.2355 2.08177 18.0995 2.02924L18.0854 2.02377L18.0713 2.01808C18.0265 1.99999 18.0069 2 18.001 2C17.994 2 17.9594 2.00044 17.8873 2.02788L11.4268 4.56481C10.8319 4.81107 10.2692 5.25077 9.75107 5.98732C9.25873 6.72106 9.07143 7.37581 9.07143 7.98182V12.5636C9.07143 13.2511 9.1737 13.9797 9.39312 14.755C9.63727 15.5321 9.97045 16.2688 10.3944 16.9684C10.8075 17.6267 11.2954 18.2157 11.8603 18.7393C12.3996 19.1953 12.9737 19.5157 13.5895 19.7184L14.9643 20.1709V21.6182C14.9643 22.395 14.8499 23.1921 14.6453 24L14.6431 24.0085L14.6409 24.017C14.1837 25.7583 12.6809 26.4724 11.3385 26.6824L4.16324 27.9475C3.52384 28.0774 3.03163 28.3752 2.61773 28.8825L2.60898 28.8933L2.60009 28.9039C2.19256 29.3895 2 29.9153 2 30.5636V35H29.8547C29.7133 34.797 29.5714 34.5901 29.4294 34.3796C28.3459 32.7738 27.2481 30.9442 26.4181 29.0916C26.1694 28.5364 25.9416 27.9724 25.7448 27.4061ZM35.0709 37.1301C34.8668 37.3816 34.6804 37.6068 34.5167 37.802C34.3529 37.6068 34.1666 37.3816 33.9624 37.1301C33.1768 36.1621 32.1311 34.808 31.0873 33.261C30.0416 31.7111 29.0102 29.9857 28.2433 28.2739C27.4706 26.549 27 24.9112 27 23.5167C27 19.3605 30.3605 16 34.5167 16C38.6729 16 42.0333 19.3605 42.0333 23.5167C42.0333 24.9112 41.5628 26.549 40.79 28.2739C40.0231 29.9857 38.9917 31.7111 37.946 33.261C36.9023 34.808 35.8565 36.1621 35.0709 37.1301Z" fill="currentColor"/></SVG>;

registerBlockType( 'jet-smart-filters/user-geolocation', {
	title: __( 'User Geolocation' ),
	icon: Icon,
	category: 'jet-smart-filters',
	supports: {
		html: false
	},
	attributes: {
		// General
		filter_id: {
			type: 'number',
			default: 0,
		},
		content_provider: {
			type: 'string',
			default: 'not-selected',
		},
		query_id: {
			type: 'string',
			default: '',
		},
	},
	className: 'jet-smart-filters-alphabet',
	edit: class extends wp.element.Component {

		getOtptionsFromObject( object ) {

			const result = [];

			for ( const [ value, label ] of Object.entries( object ) ) {
				result.push( {
					value: value,
					label: label,
				} );
			}

			return result;

		}

		render() {
			
			const props = this.props;

			return [
				props.isSelected && (
					<InspectorControls
						key={'inspector'}
					>
						<PanelBody title={__( 'General' )}>
							<div>
								<h4 style={{margin:'5px 0 0'}}>Please note!</h4>
								<p style={{ color: '#757575', fontSize: '12px' }}>
									This filter is compatible only with queries from JetEngine Query Builder. ALso you need to set up <a href="https://crocoblock.com/knowledge-base/jetengine/how-to-set-geo-search-based-on-user-geolocation/" target="_blank">Geo Query</a> in your query settings to make the filter work correctly.
								</p>
							</div>
							<SelectControl
								label={ __( 'Select filter' ) }
								value={ props.attributes.filter_id }
								options={ this.getOtptionsFromObject( window.JetSmartFilterBlocksData.filters['user-geolocation'] ) }
								onChange={ newValue => {
									props.setAttributes({ filter_id: Number(newValue) });
								} }
							/>
							<SelectControl
								label={ __( 'This filter for' ) }
								value={ props.attributes.content_provider }
								options={ this.getOtptionsFromObject( window.JetSmartFilterBlocksData.providers ) }
								onChange={ newValue => {
									props.setAttributes({ content_provider: newValue });
								} }
							/>
							<TextControl
								type="text"
								label={ __( 'Query ID' ) }
								help={ __( 'Set unique query ID if you use multiple blocks of same provider on the page. Same ID you need to set for filtered block.' ) }
								value={ props.attributes.query_id }
								onChange={ newValue => {
									props.setAttributes( { query_id: newValue } );
								} }
							/>
						</PanelBody>
					</InspectorControls>
				),
				<Disabled key={ 'block_render' }>
					<ServerSideRender
						block="jet-smart-filters/user-geolocation"
						attributes={ props.attributes }
					/>
				</Disabled>
			];

		}

	},
	save: props => {
		return null;
	},
} );
