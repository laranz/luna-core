/**
 * Main JS file for our plugin admin side.
 *
 * @package luna-core
 */

window.addEventListener(
	"load",
	function () {
		// Store tab variables.
		let tabs       = document.querySelectorAll( "ul.nav-tabs > li" );
		let tabsLength = tabs.length;

		for ( let i = 0; i < tabsLength; i++ ) {
			tabs[i].addEventListener( "click", switchTab );
		}

		function switchTab( event ) {
			event.preventDefault();

			document.querySelector( "ul.nav-tabs li.active" ).classList.remove( "active" );
			document.querySelector( ".tab-pane.active" ).classList.remove( "active" );

			let clickedTab   = event.currentTarget;
			let anchor       = event.target;
			let activePaneID = anchor.getAttribute( "href" );

			clickedTab.classList.add( "active" );
			document.querySelector( activePaneID ).classList.add( "active" );
		}
	}
);
