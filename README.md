Minit Manual Inclusion
======================

[Plugin author](http://blog.milandinic.com/) | [Donate](http://blog.milandinic.com/donate/)

*This is an extension to [Minit](https://github.com/kasparsd/minit) plugin by [Kaspars Dambis](http://kaspars.net/), if you don't have it activated nothing will happen.*

By default, Minit combines every file that is enqueued on that page. Problem with this is that different pages can have different files enqueued so user will need to download everything.

This plugin changes that and combines only files that are already manually whitelisted with the help of filters.

When you whitelist, you provide handles by which those files are registered.

For CSS (example: Twenty Fifteen theme):

```
function md_mmi_css( $todo ) {
	$todo = array( 'genericons', 'twentyfifteen-style' );

	return $todo;
}
add_filter( 'minit_manual_inclusion_css', 'md_mmi_css' );
```

For JavaScript (example: Twenty Fifteen theme):

```
function md_mmi_js( $todo ) {
	$todo = array( 'twentyfifteen-skip-link-focus-fix', 'jquery-core', 'jquery-migrate', 'jquery', 'twentyfifteen-script' );

	return $todo;
}
add_filter( 'minit_manual_inclusion_js', 'md_mmi_js' );
```

You can also choose whether to enqueue combined file you get from Minit before or after all files of that type. By default, Minit file is enqueue first. To change that, you can add one or both following examples:

```
add_filter( 'minit_manual_inclusion_enqueue_css_late', '__return_false' );
```

```
add_filter( 'minit_manual_inclusion_enqueue_js_late', '__return_false' );
```
