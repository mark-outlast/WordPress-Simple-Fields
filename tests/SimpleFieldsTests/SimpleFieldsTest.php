<?php
/**
 * MyPlugin Tests
 */
class MyPluginTest extends WP_UnitTestCase {

	public function setUp()
	{
		parent::setUp();
		global $sf;
		$this->sf = $sf;
	}

	public function testAppendContent()
	{
		#$this->assertEquals( "<p>Hello WordPress Unit Tests</p>", $this->my_plugin->append_content(''), '->append_content() appends text' );
	}

	// test defaults, should all be empty since we cleared the db...
	function testDefaults()
	{
		$this->assertEquals(array(), $this->sf->get_post_connectors());
		$this->assertEquals(array(), $this->sf->get_field_groups());
		$this->assertEquals(array(), $this->sf->get_field_groups());
	}

	// Test output of debug function
	function test_debug()
	{
		$this->expectOutputString("<pre class='sf_box_debug'>this is simple fields debug function</pre>");
		sf_d("this is simple fields debug function");
	}

	// insert and test manually added fields
	function testManuallyAddedFields()
	{

		_insert_manually_added_fields();

		$post_id = 11;

		// test single/first values
		$this->assertEquals("Text entered in the text field", simple_fields_value("field_text", $post_id));
		$this->assertEquals("Text entered in the textarea", simple_fields_value("field_textarea", $post_id));
		$this->assertEquals("<p>Text entered in the TinyMCE-editor.</p>\n", simple_fields_value("field_textarea_html", $post_id));
		$this->assertEquals("1", simple_fields_value("field_checkbox", $post_id));
		$this->assertEquals("radiobutton_num_4", simple_fields_value("field_radiobuttons", $post_id));
		$this->assertEquals("dropdown_num_3", simple_fields_value("field_dropdown", $post_id));
		$this->assertEquals(14, simple_fields_value("field_file", $post_id));
		$this->assertEquals(11, simple_fields_value("field_post", $post_id));
		$this->assertEquals("post_tag", simple_fields_value("field_taxonomy", $post_id));
		$this->assertEquals(array(0 => 1), simple_fields_value("field_taxonomy_term", $post_id));
		$this->assertEquals("FF3C26", simple_fields_value("field_color", $post_id));
		$this->assertEquals("12/10/2012", simple_fields_value("field_date", $post_id));
		$this->assertEquals(1, simple_fields_value("field_user", $post_id));

		// test repeatable/all values
		$val = array(
			0 => "Text entered in the text field",
			1 => "text in textfield 2<span>yes it is</span>"
		);
		$this->assertEquals($val, simple_fields_values("field_text", $post_id));

		$val = array(
			0 => "Text entered in the textarea",
			1 => "Textera with more funky text in it.

<h2>Headline</h2>
<ul>
	<li>Item 1</li>
	<li>Item 2</li>
</ul>


"
		);
		$this->assertEquals($val, simple_fields_values("field_textarea", $post_id));

		$val = array(
			0 => "<p>Text entered in the TinyMCE-editor.</p>
",
			1 => '<p>Tiny editors are great!</p>
<p>You can style the content and insert images and stuff. Groovy! Funky!</p>
<h2>A list</h2>
<ul>
<li>List item 1</li>
<li>List item 2</li>
</ul>
<h2>And images can be inserted</h2>
<p><a href="http://unit-test.simple-fields.com/wordpress/wp-content/uploads/2012/10/product-cat-2.jpeg"><img class="alignnone  wp-image-14" title="product-cat-2" src="http://unit-test.simple-fields.com/wordpress/wp-content/uploads/2012/10/product-cat-2.jpeg" alt="" width="368" height="277" /></a></p>

');
		$this->assertEquals($val, simple_fields_values("field_textarea_html", $post_id));


	}



	/**
	 * A contrived example using some WordPress functionality
	 */
	public function testPostTitle()
	{

		// This will simulate running WordPress' main query.
		// See wordpress-tests/lib/testcase.php
		# $this->go_to('http://unit-test.simple-fields.com/wordpress/?p=1');

		// Now that the main query has run, we can do tests that are more functional in nature
		#global $wp_query;
		#sf_d($wp_query);
		#$post = $wp_query->get_queried_object();
		#var_dump($post);
		#$this->assertEquals('Hello world!', $post->post_title );
		#$this->assertEquals('Hello world!', $post->post_title );
	}
}
