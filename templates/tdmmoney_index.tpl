<table border='0' cellspacing='5' cellpadding='0' align="center">
    <tr>
        <!-- Start account loop -->
        <{foreach item=account from=$account}>
        <td valign="top" width="50" >
            <a href="<{$module_url}>viewaccount.php?account_id=<{$account.account_id}>"><img src="<{$module_url}>assets/images/deco/doc.png" border="0" alt=""></a></td>
        <td valign="top" width="200">
            <a href="<{$module_url}>viewaccount.php?account_id=<{$account.account_id}>"><b><{$account.account_name}></b></a>
            <br><br><{$smarty.const._MD_TDMMONEY_INDEX_BALANCE}>: <{$account.balance}><br><br>
        </td>
    <{if $account.count is div by 3}>
    </tr>
    <tr>
    <{/if}>
        <{/foreach}>
        <!-- End account loop -->
    </tr>
</table>
