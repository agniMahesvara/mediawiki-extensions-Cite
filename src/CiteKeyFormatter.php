<?php

namespace Cite;

use Sanitizer;

/**
 * @license GPL-2.0-or-later
 */
class CiteKeyFormatter {

	/**
	 * Return an id for use in wikitext output based on a key and
	 * optionally the number of it, used in <references>, not <ref>
	 * (since otherwise it would link to itself)
	 *
	 * @param string $key
	 * @param string|null $num The number of the key
	 * @return string A key for use in wikitext
	 */
	public function refKey( string $key, string $num = null ) : string {
		// FIXME: Move the message to 'cite_ref_link_*'
		$prefix = wfMessage( 'cite_reference_link_prefix' )->inContentLanguage()->text();
		$suffix = wfMessage( 'cite_reference_link_suffix' )->inContentLanguage()->text();
		if ( $num !== null ) {
			$key = wfMessage( 'cite_reference_link_key_with_num', $key, $num )
				->inContentLanguage()->plain();
		}

		return $this->normalizeKey( $prefix . $key . $suffix );
	}

	/**
	 * Return an id for use in wikitext output based on a key and
	 * optionally the number of it, used in <ref>, not <references>
	 * (since otherwise it would link to itself)
	 *
	 * @param string $key
	 * @return string A key for use in wikitext
	 */
	public function getReferencesKey( string $key ) : string {
		$prefix = wfMessage( 'cite_references_link_prefix' )->inContentLanguage()->text();
		$suffix = wfMessage( 'cite_references_link_suffix' )->inContentLanguage()->text();

		return $this->normalizeKey( $prefix . $key . $suffix );
	}

	/**
	 * Normalizes and sanitizes a reference key
	 *
	 * @param string $key
	 * @return string
	 */
	private function normalizeKey( string $key ) : string {
		$ret = Sanitizer::escapeIdForAttribute( $key );
		$ret = preg_replace( '/__+/', '_', $ret );
		$ret = Sanitizer::safeEncodeAttribute( $ret );

		return $ret;
	}

}
