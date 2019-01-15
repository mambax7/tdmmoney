<div id="help-template" class="outer">
    <{include file=$smarty.const._MI_TDMMONEY_HELP_HEADER}>

    <h4 class="odd">DESCRIPTION</h4> <br>

    <p class="even">This module allows for the administration of personal finance.<br><br></p>

    <h4 class="odd">INSTALL/UNINSTALL</h4>
    No special measures necessary, follow the standard installation process
    extract the /TDMMoney folder into the ../modules directory. Install the module through Admin -> System Module -> Modules.
    <br><br>
    Detailed instructions on installing modules are available in the
    <a href="https://xoops.gitbook.io/xoops-operations-guide/" target="_blank">XOOPS Operations Manual</a>
    <h4 class="odd">Operating instructions</h4>
    <p class="even">
        To set up this module you need to:
        <br><br>
        i) Configure your preferences for the module (see "Preferences") and
        optionally the Partners block if you intend to use it (see
        Blocks)
        <br><br>
        ii) Check that you have given your user groups the necessary module and
        block access rights to use this module. Group permissions are set through
        the Administration Menu -> System -> Groups.
        <br><br>
        Detailed instructions on configuring the access rights for user groups are available in the
        <a href="https://xoops.gitbook.io/xoops-operations-guide/" target="_blank">XOOPS Operations Manual</a>
    </p>
    <h5>TCPDF Installation in XOOPS 2.5.8+</h5>
    <p>If you want to use the PDF feature in TdmMoney, you will need to copy the TCPDF library to your XOOPS folder: <span style='font-family: "Courier New", Courier, monospace;'>/class/libraries/vendor/</span></p>
    <ol type="a">
    <li>Create the following folders there: <span style='font-family: "Courier New", Courier, monospace;'>/tecnickcom/tcpdf/</span> so it looks like: <span style='font-family: "Courier New", Courier, monospace;'>/class/libraries/vendor/tecnickcom/tcpdf/</span></li>
    <li>Download the TCPDF library. You have three choices:<br>
    <ul type="i">
    <li>Download the streamlined XOOPS version from: <span style='font-family: "Courier New", Courier, monospace;'><a href="http://sourceforge.net/projects/chgxoops/files/Frameworks/tcpdf_for_xoops/" target="_blank">http://sourceforge.net/projects/chgxoops/files/Frameworks/tcpdf_for_xoops/</a></span></li>
    <li>Download the latest full release from: <span style='font-family: "Courier New", Courier, monospace;'><a href="https://github.com/tecnickcom/TCPDF/releases" target="_blank">https://github.com/tecnickcom/TCPDF/releases</a></span></li>
    <li>If you feel comfortable with Composer (<span style='font-family: "Courier New", Courier, monospace;'>https://getcomposer.org/</span>) add this line to your "composer.js" file located in <span style='font-family: "Courier New", Courier, monospace;'>/class/libraries/</span>:
    <span style='font-family: "Courier New", Courier, monospace;'>"tecnickcom/tcpdf":"6.*"</span> and then run the command: composer update<br>Your PDF should now work.</li>
    </ul></li></ol>
    <h4 class="odd">TUTORIAL</h4> <br>
    <p class="even">
        Tutorial has been started, but we might need your help! Please check out the status of the tutorial <a href="https://xoops.gitbook.io/tdmmoney-tutorial/" target="_blank">here </a>.
        <br><br>To contribute to this Tutorial, <a href="https://github.com/XoopsDocs/tdmmoney-tutorial/" target="_blank">please fork it on GitHub</a>.
        <br> This document describes our <a href="https://xoops.gitbook.io/xoops-documentation-process/details/" target="_blank">Documentation Process</a> and it will help you to understand how to contribute.
        <br><br>
        There are more XOOPS Tutorials, so check them out in our <a href="https://www.gitbook.com/@xoops/" target="_blank">XOOPS Tutorial Repository on GitBook</a>.
    </p>
    <h4 class="odd">TRANSLATIONS</h4> <br>
    <p class="even">Translations are on <a href="https://www.transifex.com/xoops/" target="_blank">Transifex</a> and in our <a href="https://github.com/XoopsLanguages/" target="_blank">XOOPS Languages Repository on GitHub</a>.</p>
    <h4 class="odd">SUPPORT</h4> <br>
    <p class="even">If you have questions about this module and need help, you can visit our <a href="https://xoops.org/modules/newbb/viewforum.php?forum=28/" target="_blank">Support Forums on XOOPS Website</a></p>
    <h4 class="odd">DEVELOPMENT</h4> <br>
    <p class="even">
        This module is Open Source and we would love your help in making it better! You can fork this module on <a href="https://github.com/XoopsModulesArchive/tdmmoney" target="_blank">GitHub</a><br><br>
        But there is more happening on GitHub:<br><br>
        - <a href="https://github.com/xoops" target="_blank">XOOPS Core</a> <br>
        - <a href="https://github.com/XoopsModules25x" target="_blank">XOOPS Modules</a><br>
        - <a href="https://github.com/XoopsThemes" target="_blank">XOOPS Themes</a><br><br>
        Go check it out, and <strong>GET INVOLVED</strong>
    </p>
</div>
