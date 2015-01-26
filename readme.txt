Out-of-Office

For full details visit us at http://codemarker.co.uk/codemarker/out-of-office/

Out-of-Office is our rudimentary online/offline indicator with bells and whistles.

With this plugin/widget you can:

    set your status online,
    state a title
    state a description
    show the indicator
    and show a post message.


Widget
shortcode
Hooks

Out of office can be used in a few ways.

Widget

To use the widget, just go to the widget screen, change the settings there and then save.
On the admin section of widgets, you will be given the option of where to put your widget (sidebar, footer, header etc depending on your theme).
Once saved you will find OOO displayed.

Of course this doesnt provide that much flexibility especially if you want your OOO to be displayed on a specific screen or when there is a certain content type.

Hooks & shortcode

Shortcode is the straight forward code that allows any user to really add OOO to their content like so
[out_of_office]

If you are a seasoned programmer then you can choose to use a hook to display the content.
	if(function_exists('out_of_office'))
	{
		do_action('out_of_office');
	}
	

For now Out-of-office is fairly basic and we hope to add more functionality to it.
We have provided 'user_style.css' in the 'css' folder for users to style colors and properties that maybe displayed.

Each and every input has an on/off display switch so the user may or may not choose to display.