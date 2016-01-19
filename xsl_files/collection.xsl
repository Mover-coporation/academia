<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="reportmodule">
        <xsl:for-each select="report">

        <html>
            <head>
                <title> REPORT MODULE
                </title>


                <link rel="stylesheet" type="text/css"  href="../xsl_files/styles/style.css"/>
            </head>
            <body>
                <div id="wrapper">

                      <div class="header" id="header" style="display:block;">

                          <table width="100%">

                              <tr>
                                  <th width="1%;" style="text-align:left;" id="h_img">

                                      <xsl:element name="img">
                                          <xsl:attribute name="src">
                                              <xsl:value-of select="head/logo1"/>
                                          </xsl:attribute>
                                          <xsl:attribute name="id">moee </xsl:attribute>
                                      </xsl:element>
                                  </th>
                                  <!-- <img src = <xsl:value-of select="report/head/logo1"/> /> -->
                                  <!-- <img width="118" height="96" src=<xsl:value-of select="report/head/logo1"/>  align="left" hspace="12" /> -->
                                  <th > <h1 style="margin:0 auto; text-transform:uppercase; padding:0px; text-align:center; font-size:24px; text-align:center; width:80%; " id="titl"><xsl:value-of select="head/title"/> </h1>
                                      <h1 id="email" style="" >  P.O BOX 48 KANUNGU</h1>
                                      <h1 id="email" style="" >Email: info@victorynpschool.com</h1>

                                      <h1 id="tel" style="" >Tel: 0772857749 / 0774353844</h1>
                                      <h1 id="motto" style="" >“Foundation for a bright future”</h1>
                                      <h1 id="trm" style="" > <xsl:value-of select="head/term"/>  Progress Report</h1>
                                  </th>
                                  <th id="h_img" style="">  </th> </tr>
                              <tr >
                                  <td  colspan="2" id="pupil">

                                      <div style="float:left; min-width:1%;padding:2px;"> <label id="pp">PUPIL'S NAME : </label><xsl:value-of select="head/names"/> </div>
                                      <div  style="float:left; min-width:1%;padding:2px;">Class : <xsl:value-of select="head/class"/>  </div>
                                      <div  style="float:left; min-width:1%; padding:2px;" >Term : <xsl:value-of select="head/term"/>  </div>

                                  </td>
                              </tr>

                          </table>
                      </div>




                    <div id="student_if0">
                        <div id="name">
                        </div>
                        <div id="class">
                        </div>
                        <div id="term">
                        </div>
                    </div>

                    <div id="report">

                        <table width="100%" border="1" cellpadding="0" id="rptm">
                            <tr>
                                <th width="72" id="leftbar" >SUBJECTS</th>
                                <th width="31">FULL MAKRS</th>

                                <xsl:for-each select="exams/exam">
                                    <th width="8" align="center"><xsl:value-of select="examname"/></th>

                                </xsl:for-each>


                                <th width="8" align="center">   AV. MRKS</th>

                                <th width="32">AGG</th>
                                <th width="53">POSITION</th>
                                <th width="53">RMKS</th>
                                <th width="53">INIIAL</th>
                            </tr>
                            <xsl:for-each select="subjects/subject">
                                <tr>
                                    <th id="leftbar"><xsl:value-of select="subjectname"/></th>
                                    <xsl:variable name="ss" select="subjectid"/>
                                    <td>  </td>

                                    <xsl:for-each select=".">

                                        <xsl:for-each select="../../marksheet/examid">

                                            <xsl:variable name="ss2" select="examd" />


                                            <xsl:choose>
                                                <xsl:when test="($ss = $ss2)  ">

                                                    <xsl:for-each select="exams">

                                                        <td >
                                                            <xsl:value-of select="marks"/>  </td>
                                                    </xsl:for-each>

                                                    <td >
                                                        <xsl:value-of select="avmark"/>  </td>
                                                    <td >
                                                    </td>
                                                    <td >
                                                        <xsl:value-of select="examposition"/>  </td>
                                                    <td >
                                                        <xsl:value-of select="examremarks"/>  </td>
                                                    <td >
                                                        <xsl:value-of select="examinitial"/>  </td>

                                                </xsl:when>
                                                <xsl:otherwise>


                                                </xsl:otherwise>

                                            </xsl:choose>

                                        </xsl:for-each>

                                    </xsl:for-each>
                                </tr>




                            </xsl:for-each>


<tr>
    <td>SUBTOTALS </td>
<td></td>
    <xsl:for-each select="marksheet/subtotos">

    <td>  <xsl:value-of select="."/> </td>
    </xsl:for-each>
    <td>  <xsl:value-of select="marksheet/totalas"/> </td>
</tr>
   <tr>
  <td>TOTAL </td>
    <td COLSPAN="100%">
       <xsl:value-of select="marksheet/totalas"/> </td>
     </tr>

                        </table>
                    </div>
                </div>

                <div class=" footer  ff" style="display:block;">
                    <table>

                        <tr>
                            <td>  <div id="postin">
                                <label id="hda">POSITION IN CLASS : </label><label> <!-- <xsl:value-of select="marksheet/position"/> --> </label>
                                <label id="hda">OUT OF   </label><label> <xsl:value-of select="marksheet/numstudents"/>  </label>
                                <label id="hda">CONDUCT   </label> <label> :: </label>
                            </div></td>
                        </tr>
                        <tr>
                            <td>
                                <div id="postin">
                                    <label >Conduct  : </label><label> ..............................................................................................................................</label><br style="clear:both; margin:0px;"/>
                                    <label >Class teacher’s report </label><label>........................................................................................................................</label><br style="clear:both; margin:0px;"/>
                                    <label >Head teacher’s report:    </label> <label>....................................................................................................................... </label><br style="clear:both; margin:0px;"/>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="postin">
                                    <label>..............................................................</label>
                                    <label >Signature n stampt:  ............................................................ </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="postin">
                                    <label >Tuition fee : _____________Lunch fee :______________Report :______________</label> </div>
                                <div id="postin">
                                    <label >NOTE: All pupils SHOULD report at school for the new term with enough books, pencils and pens.  </label>
                                    <label >Next term begins on:_______________Ends on _________________ </label>


                                </div>

                            </td>
                        </tr>
                    </table>

</div>
                <hr style="width:100%" />
            </body>
        </html>

        </xsl:for-each>
    </xsl:template>


</xsl:stylesheet>
