<H2><{$account_name}></H2>
<div align="right">
    <form name="nav" action="journal.php" method="post">
        <{if $perm_add != ""}>
        <input type="button" value="<{$smarty.const._MD_TDMMONEY_VIEWACCOUNT_ADD}>" onclick="location='submit.php'">
        <{/if}>
        <{if $perm_modif != ""}>
        <{*<input type="button" value="<{$smarty.const._MD_TDMMONEY_VIEWACCOUNT_EXPORTPDF}>" onclick="location='include/operation_pdf.php?account_id=<{$account_id}>&date_start=<{$date_start}>&date_end=<{$date_end}>'">*}>
        <{if $displayPdf == 1}>
            <input type="button" value="<{$smarty.const._MD_TDMMONEY_VIEWACCOUNT_EXPORTPDF}>" onclick="location='makepdf.php?account_id=<{$account_id}>&date_start=<{$date_start}>&date_end=<{$date_end}>'">
        <{/if}>
        <{/if}>
    </form>
</div>
<br>
<{$form}>
<br>
<{if $numrows != 0}>
<table align='center' class='outer'>
    <tr>
        <th width='10%' align='left'><{$smarty.const._MD_TDMMONEY_VIEWACCOUNT_DATE}></th>
        <th width='10%' align='left'><{$smarty.const._MD_TDMMONEY_VIEWACCOUNT_SENDER}></th>
        <th width='20%' align='left'><{$smarty.const._MD_TDMMONEY_VIEWACCOUNT_CATEGORY}></th>
        <th align='left'><{$smarty.const._MD_TDMMONEY_VIEWACCOUNT_DESCRIPTION}></th>
        <th width='8%' align='center'><{$smarty.const._MD_TDMMONEY_VIEWACCOUNT_WITHDRAW}></th>
        <th width='8%' align='center'><{$smarty.const._MD_TDMMONEY_VIEWACCOUNT_DEPOSIT}></th>
        <th width='8%' align='right'><{$smarty.const._MD_TDMMONEY_VIEWACCOUNT_BALANCE}></th>
        <{if $perm_modif != ""}>
        <th width='8%' align='center'><{$smarty.const._MD_TDMMONEY_ACTION}></th>
        <{/if}>
    </tr>
    <{foreach item=operation from=$operation}>
    <tr class="<{cycle values='odd, even'}>">
        <td align='left'><{$operation.operation_date}></td>
        <td align='left'><{$operation.operation_sender}></td>
        <td align='left'><{$operation.operation_category}></td>
        <td align='left'><{$operation.operation_description}></td>
        <td align='center'><{$operation.operation_withdraw}></td>
        <td align='center'><{$operation.operation_deposit}></td>
        <td align='right'><{$operation.operation_balance}></td>
        <{if $perm_modif != ""}>
        <td align='center'><{$operation.operation_action}></td>
        <{/if}>
    </tr>
    <{/foreach}>
    <tr>
        <td align='right' colspan='6'><{$operation_report}></td>
        <td align='right'><{$operation_balance}></td>
    </tr>
</table>
<{/if}>
