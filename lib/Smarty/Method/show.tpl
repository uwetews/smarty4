/* This CSS is used for the Show/Hide functionality. */
.more {
display: none;
border-top: 1px solid #666;
border-bottom: 1px solid #666; }
a.showLink, a.hideLink {
text-decoration: none;
color: #36f;
padding-left: 8px;
background: transparent url(down.gif) no-repeat left; }
a.hideLink {
background: transparent url(up.gif) no-repeat left; }
a.showLink:hover, a.hideLink:hover {
border-bottom: 1px dotted #36f; }
</style>
<

/
head >
< body >
< div id

=
"wrap"
>
<
h1 > Show

/
Hide Content<

/
h1 >
< p > < a href

=
"/showhide-content-css-javascript/"
>
Go back to the main article.<

/
a > This example shows you how to create a show

/
hide container using a couple of links, a div, a few lines of CSS, and some JavaScript to manipulate our CSS. Just click on the

"see more"
link at the end of this paragraph to see the technique in action, and be sure to view the source to see how it all works together.

<
a href

=
"#"
id

=
"example-show"
class

=
"showLink"
onclick

=
"showHide('example');return false;"
>
See more.<

/
a > <

/
p >
< div id

=
"example"
class

=
"more"
>
<
p > Congratulations! You

've found the magic hidden text! Clicking the link below will hide this content again.</p>
<
p > < a href

=
"#"
id

=
"example-hide"
class

=
"hideLink"
onclick

=
"showHide('example');return false;"
>
Hide this content.<

/
a > <

/
p >
<

/
div >
<

/
div >
<

/
body >
<

/
html >