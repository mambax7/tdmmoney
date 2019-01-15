READ ME FIRST
_____________________________________________________________________


 REQUIREMENTS
 _____________________________________________________________________

- PHP version >= 5.5
- XOOPS version >= 2.5.8

INSTALLATION
_____________________________________________________________________

1) You install the module as just any other XOOPS module.
Detailed instructions on installing modules are available in the XOOPS Operations Manual:
https://xoops.gitbook.io/xoops-operations-guide/details"

2) PDF in XOOPS 2.5.8
If you want to use the PDF feature in TdmMoney, you will need to copy the TCPDF library to your XOOPS folder:

/class/libraries/vendor/

a) create the folders there:

/tecnickcom/tcpdf/

so it looks like:

/class/libraries/vendor/tecnickcom/tcpdf/

b) download the TCPDF library. You have three choices:

 i) download the streamlined XOOPS version from: http://sourceforge.net/projects/chgxoops/files/Frameworks/tcpdf_for_xoops/

 ii) download the latest full release from: https://github.com/tecnickcom/TCPDF/releases

 iii) If you feel comfortable with Composer (https://getcomposer.org/) add this line to your "composer.js" file located in /class/libraries/:

  "tecnickcom/tcpdf":"6.*"

and then run the command:

    composer update

Your PDF should now work.

Enjoy your XOOPS TdmMoney module!

Your XOOPS Development Team

