<?php

class NumberFormat {

	/**
	 * Register number_format parser function
	 *
	 * @param Parser $parser
	 */
	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setFunctionHook( 'number_format', [ self::class, 'formatNumber' ] );
	}

	/**
	 * Format a given number
	 *
	 * {{#number_format:number|decimals|dec_point|thousands_sep}}
	 *
	 * @param Parser $parser
	 * @return mixed
	 */
	public static function formatNumber( Parser $parser ) {
		// Get the parameters that were passed to this function
		$params = func_get_args();
		array_shift( $params );
		$paramcount = count( $params );

		if ( isset( $params[0] ) && $params[0] == '' ) {
			return '';
		}

		switch ( $paramcount ) {
			// phpcs:ignore PSR2.ControlStructures.SwitchDeclaration.TerminatingComment
			case 5:
				// Since 'space' cannot be passed through parser functions, users are advised to use
				// the underscore instead. Converting back to space here.
				if ( $params[4] == '_' ) {
					$params[4] = ' ';
				}
				$params[0] = str_replace( $params[4], '.', $params[0] );
			case 4:
				if ( $params[3] == '_' ) {
					$params[3] = ' ';
				} // Converting back to space
			case 3:
				if ( $params[2] == '_' ) {
					$params[2] = ' ';
				} // Converting back to space
			case 2:
				if ( $params[1] == '_' ) {
					$params[1] = strrpos( $params[0], '.' ) ? strlen( $params[0] ) - strrpos( $params[0], '.' ) - 1 : 0;
				} // Number of decimal points same as input
			case 1:
				break;
			case 0:
				return ''; // Empty output for empty input
			default:
				return '<span class="error">' . wfMessage( 'numberformat_wrongnargs' )->escaped() . '</span>';
		}

		$params[0] = preg_replace( "/[^\\.\\-0-9e]*/", "", $params[0] ); // Set to plain number
		if ( !is_numeric( $params[0] ) ) {
			return '<span class="error">' . wfMessage( 'numberformat_firstargument' )->escaped() . '</span>';
		}
		$output = number_format(
			(float)$params[0],
			isset( $params[1] ) ? (int)$params[1] : null,
			$params[2] ?? null,
			$params[3] ?? null
		);

		if ( isset( $params[3] ) ) {
			switch ( $params[3] ) {
				case 't':
					$output = str_replace( 't', '&thinsp;', $output );
					break;
				case 'n':
					$output = str_replace( 'n', '&nbsp;', $output );
					break;
			}
		}

		return $output;
	}
}
