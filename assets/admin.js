/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/admin.scss';

// start the Stimulus application
import $ from "jquery";
import './bootstrap';

 /* Import TinyMCE */
 import tinymce from 'tinymce';

 /* Default icons are required for TinyMCE 5.3 or above */
 import 'tinymce/icons/default';

 /* A theme is also required */
 import 'tinymce/themes/silver';

 /* Import the skin */
 import 'tinymce/skins/ui/oxide/skin.css';

 /* Import plugins */
//  import 'tinymce/plugins/advlist';
//  import 'tinymce/plugins/code';
//  import 'tinymce/plugins/emoticons';
//  import 'tinymce/plugins/emoticons/js/emojis';
//  import 'tinymce/plugins/link';
//  import 'tinymce/plugins/lists';
//  import 'tinymce/plugins/table';

 /* Initialize TinyMCE */
tinymce.init({
  'use_callback_tinymce_init': true,
  selector: '.tinymce'
});


import './admin/app.js';
