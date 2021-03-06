<?php
/**
 * MslsAdminIcon
 * @author Dennis Ploetner <re@lloc.de>
 * @since 0.9.8
 */

/**
 * Handles the icon links in the backend
 * @package Msls
 */
class MslsAdminIcon {

	/**
	 * Language
	 * @var string
	 */
	protected $language;

	/**
	 * Source
	 * @var string
	 */
	protected $src;

	/**
	 * URL
	 * @var string
	 */
	protected $href;

	/**
	 * Blog id
	 * @var int
	 */
	protected $blog_id;

	/**
	 * Type
	 * @var string
	 */
	protected $type;

	/**
	 * Path
	 * @var string
	 */
	protected $path = 'post-new.php';

	/**
	 * Factory method
	 * @return MslsAdminIcon
	 */
	public static function create() {
		$obj  = MslsContentTypes::create();
		$type = $obj->get_request();
		if ( $obj->is_taxonomy() )
			return new MslsAdminIconTaxonomy( $type );
		return new MslsAdminIcon( $type );
	}

	/**
	 * Constructor
	 * @param string $type
	 */
	public function __construct( $type ) {
		$this->type = esc_attr( $type );
		$this->set_path();
	}

	/**
	 * Set the path by type
	 * @return MslsAdminIcon
	 */
	protected function set_path() {
		if ( 'post' != $this->type ) {
			$this->path = add_query_arg(
				array( 'post_type' => $this->type ),
				$this->path
			);
		}
		return $this;
	}

	/**
	 * Set language
	 * @param string $language
	 * @return MslsAdminIcon
	 */
	public function set_language( $language ) {
		$this->language = $language;
		return $this;
	}

	/**
	 * Set src
	 * @param string $src
	 * @return MslsAdminIcon
	 */
	public function set_src( $src ) {
		$this->src = $src;
		return $this;
	}

	/**
	 * Set href
	 * @param int $id
	 * @return MslsAdminIcon
	 */
	public function set_href( $id ) {
		$this->href = get_edit_post_link( (int) $id );
		return $this;
	}

	/**
	 * Handles the output when object is treated like a string
	 * @return string
	 */
	public function __toString() {
		return $this->get_a();
	}

	/**
	 * Get image as html-tag
	 * @return string
	 */
	public function get_img() {
		return sprintf(
			'<img alt="%s" src="%s" />',
			$this->language,
			$this->src
		);
	}

	/**
	 * Get link as html-tag
	 * @return string
	 */
	protected function get_a() {
		if ( !empty( $this->href ) ) {
			$href  = $this->href;
			$title = sprintf(
				__( 'Edit the translation in the %s-blog', 'msls' ),
				$this->language
			);
		}
		else {
			$href  = $this->get_edit_new();
			$title = sprintf(
				__( 'Create a new translation in the %s-blog', 'msls' ),
				$this->language
			);
		}
		return sprintf(
			'<a title="%s" href="%s">%s</a>&nbsp;',
			$title,
			$href,
			$this->get_img()
		);
	}

	/**
	 * Get create new link
	 * @return string
	 */
	protected function get_edit_new() {
		$path = $this->path;
		if ( has_filter( 'msls_admin_icon_get_edit_new' ) )
			$path = apply_filters( 'msls_admin_icon_get_edit_new', $path );
		return get_admin_url( get_current_blog_id(), $path );
	}

}
