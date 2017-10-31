<?php
/** @var trackHits Flag that says whether or not we should track hits at all. Set to no to disable hit tracking. */
$bsq_sitestats_trackHits = 1;
/** @var debugQueries Flag that says if we should write queries to output instead of to the database */
$bsq_sitestats_debugQueries = 0;
/** @var doIpToCountry Flag that says if we should convert IP addressed to countries (one extra SQL query per hit) */
$bsq_sitestats_doIpToCountry = 0;
/** @var doKeywordSniffing Flag that says if we should sniff keywords or not (2 extra SQL queries per hit) */
$bsq_sitestats_doKeywordSniffing = 1;
/** @var hoursBeforeCompress Integer of how many hours before we compress stats. */
$bsq_sitestats_hoursBeforeCompress = 0;
/** @var rowsPerCompress Integer that says how many rows we should compress pre compression. */
$bsq_sitestats_rowsPerCompress = 500;
/** @var cacheTime Integer that says how many seconds component reports should be cached for. */
$bsq_sitestats_cacheTime = 30;
/** @var rowLimit Integer that says how many rows to show on each component report's tab. */
$bsq_sitestats_rowLimit = 20;
/** @var cssPrepend String that says what we should prepend each class with */
$bsq_sitestats_cssPrepend = 'bsq_';
/** @var dateFormat String that dictates how to format dates in date() format. */
$bsq_sitestats_dateFormat = 'n/j/Y G:i';
/** @var useInternalCSS Boolean as to whether or not we should include bsq_sitestats's native CSS */
$bsq_sitestats_useInternalCSS = 1;
/** @var useDayBoundary Boolean as to if our periodic stats should line up with day boundaries */
$bsq_sitestats_useDayBoundary = 1;
/** @var reportHoursOffset Integer. Number of hours to offset reporting from server time. */
$bsq_sitestats_reportHoursOffset = 0;
/** @var showUsersAs Integer. Format to show users in on reports. */
$bsq_sitestats_showUsersAs = 2;
/** @var useJpGraph Integer. Should we use the JpGraph component. If this is false, graphing will be disabled. */
$bsq_sitestats_useJpGraph = 0;
/** @var graphTimeFormat String. How to format time strings when being displayed on a graph */
$bsq_sitestats_graphTimeFormat = 'G:i';
/** @var graphDateFormat String. How to format date strings when being displayed on a graph */
$bsq_sitestats_graphDateFormat = 'n/j';
/** @var graphWidth Width of the graphs to be generated with JPGraph. */
$bsq_sitestats_graphWidth = 500;
/** @var graphHeight Height of the graphs to be generated with JPGraph. */
$bsq_sitestats_graphHeight = 500;
/** @var graphForComponent Should we display graphs for reports in our component that support them? */
$bsq_sitestats_graphForComponent = 0;
/** @var graphCacheTime How long should we cache graphs for? */
$bsq_sitestats_graphCacheTime = 300;
/** @var visitorsGraphInterval What should be the tick interval for visitors graphs in the component. */
$bsq_sitestats_visitorsGraphInterval = '1day';
/** @var barChartValueColor Color of the value to the right of bars on a bar chart. */
$bsq_sitestats_barChartValueColor = '#880000';
/** @var barChartFillColor Color of the bars on a bar chart. */
$bsq_sitestats_barChartFillColor = '#FF8888';
/** @var feshowSSSummary Show the SSSummary report on the Front End? */
$bsq_sitestats_feshowSSSummary = 1;
/** @var feshowVisitorGraph Show the Visitor Graph on the Front End? */
$bsq_sitestats_feshowVisitorGraph = 1;
/** @var feshowLatestVisitors Show the Latest Visitors on the Front End? */
$bsq_sitestats_feshowLatestVisitors = 1;
/** @var feshowUserFreq Show the User Frequencies report on the Front End? */
$bsq_sitestats_feshowUserFreq = 1;
/** @var feshowResourceFreq Show the Resource Frequency report on the Front End? */
$bsq_sitestats_feshowResourceFreq = 1;
/** @var feshowBrowserFreq Show the Browser Frequency report on the Front End? */
$bsq_sitestats_feshowBrowserFreq = 1;
/** @var feshowRecentReferers Show the Recent Referers report on the Front End? */
$bsq_sitestats_feshowRecentReferers = 1;
/** @var feshowRefererFreq Show the Referer Freqeuncy report on the Front End? */
$bsq_sitestats_feshowRefererFreq = 1;
/** @var feshowDomainFreq Show the Domain Freq report on the Front End? */
$bsq_sitestats_feshowDomainFreq = 1;
/** @var feshowLanguageFreq Show the Language Frequency report on the Front End? */
$bsq_sitestats_feshowLanguageFreq = 1;
/** @var feshowKeywordFreq Show the Keyword Frequency report on the Front End? */
$bsq_sitestats_feshowKeywordFreq = 1;
?>