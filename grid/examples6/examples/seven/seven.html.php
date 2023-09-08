<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="title" align="center">-- Seven: Delete + Combos + Inner Join + Where Condition --</td>
  </tr>
  <tr>
    <td class="tableTit1" align="center">Excellent People</td>
  </tr>
  <tr>
  	<td class="tableCarga" align="center">
  		<div align="left" class="code">
		  	<p class="MsoNormal" style="text-autospace:none;"><span style="font-family:'Arial Black'; font-size:10.0pt; color:navy; ">Constructor:</span></p>
			<p class="MsoNormal" style="text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:#660000; ">&nbsp;</span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:#660000; ">$gridName </span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">= AjaxGrid::create(</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;gridName&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">array</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">(</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">new </span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">DBQueryDescriptor(</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;city&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">array</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">(</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;ID&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;Name&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">, </span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;Population&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;PeopleIs&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">)),</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">new </span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">DBQueryDescriptor(</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;peopleis&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">array</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">(</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;ID&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;Description&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">),</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DBQueryDescriptor::</span><span style="font-family:Verdana; font-size:8.0pt; color:#660000; ">$INNER_JOIN</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">'peopleis.ID =  city.PeopleIs'</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">)),</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">array</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">(</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;Actions&quot; </span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">=&gt; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">new </span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">ColumnMapped(</span><span style="font-family:Verdana; font-size:8.0pt; color:#660000; ">$actionsFormat</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">array</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">(</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;city.ID&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;city.ID&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">),</span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">false</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">'5%'</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">),</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;Pople Is&quot; </span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">=&gt; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">new </span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">ColumnComboMapped(</span><span style="font-family:Verdana; font-size:8.0pt; color:#660000; ">$comboFormat</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;peopleis&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;peopleis.ID&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;peopleis.Description&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;peopleis.ID&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">array</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">(</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;city.ID&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">),</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;peopleis.Description&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">),</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;Name&quot; </span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">=&gt; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">new </span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">ColumnMapped(</span><span style="font-family:Verdana; font-size:8.0pt; color:#660000; ">$nameFormat</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">array</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">(</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;city.Name&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">), </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">true</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">),</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;Population&quot; </span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">=&gt; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">new </span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">ColumnMapped(</span><span style="font-family:Verdana; font-size:8.0pt; color:#660000; ">$populationFormat</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">,</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;text-autospace:none;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">array</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">(</span><span style="font-family:Verdana; font-size:8.0pt; color:#008200; ">&quot;city.Population&quot;</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">), </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">true</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">)),</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
			<p class="MsoNormal" style="margin-left:9.0pt;"><span style="font-family:Verdana; font-size:8.0pt; color:black; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:Verdana; font-size:8.0pt; color:blue; ">false</span><span style="font-family:Verdana; font-size:8.0pt; color:black; ">, </span><strong><span style="font-family:Verdana; font-size:10.0pt; color:red; ">&lt;Where_Condition&gt;</span></strong><span style="font-family:Verdana; font-size:8.0pt; color:black; ">);</span><span style="font-family:Verdana; font-size:8.0pt; "> </span></p>
  		</div>
  	</td>
  </tr>
  <tr>
    <td class="tableCarga" align="center">
		
		<div><?php echo $excellentGrid->getHtml(); ?></div>
		
    </td>
  </tr>
  <tr>
    <td class="tableTit1" align="center">Very Good People</td>
  </tr>
  <tr>
    <td class="tableCarga" align="center">
		<div><?php echo $veryGoodGrid->getHtml(); ?></div>
    </td>
  </tr>
  <tr>
    <td class="tableTit1" align="center">Good People</td>
  </tr>
  <tr>
    <td class="tableCarga" align="center">
		<div><?php echo $goodGrid->getHtml(); ?></div>
    </td>
  </tr>
  <tr>
    <td class="tableTit1" align="center">No Bad People</td>
  </tr>
  <tr>
    <td class="tableCarga" align="center">
		<div><?php echo $noBadGrid->getHtml(); ?></div>
    </td>
  </tr>
  <tr>
    <td class="tableTit1" align="center">Bad People</td>
  </tr>
  <tr>
    <td class="tableCarga" align="center">
		<div><?php echo $badGrid->getHtml(); ?></div>
    </td>
  </tr>
  <tr>
    <td class="tableTit1" align="center">Very Bad People</td>
  </tr>
  <tr>
    <td class="tableCarga" align="center">
		<div><?php echo $veryBadGrid->getHtml(); ?></div>
    </td>
  </tr>
  <tr>
    <td class="tableTit1" align="center">Repugnant People</td>
  </tr>
  <tr>
    <td class="tableCarga" align="center">
		<div><?php echo $repugnantGrid->getHtml(); ?></div>
    </td>
  </tr>
</table>