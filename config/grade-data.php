<?php
error_reporting(0);
function getStudentFinalGradeDataV3(&$categoryTotals, &$categoryMap) {
    $data = array(
        'final' => array(
            'count' => array(
                'total' => 0,
                'pending' => 0,
                'overdue' => 0,
                'exempted' => 0,
                'na' => 0,
                'normal' => 0,
            ),
            'status' => '',
            'weightSum' => 0,
        ),
        'midcut' => array(
            'count' => array(
                'total' => 0,
                'pending' => 0,
                'overdue' => 0,
                'exempted' => 0,
                'na' => 0,
                'normal' => 0,
            ),
            'status' => '',
            'weightSum' => 0,
        ),
    );
    foreach($categoryTotals as $categoryId => $categoryTotal) {
        $categoryWeight = $categoryMap[$categoryId]['CategoryWeight'];
        $finalStatus = $categoryTotal['finalStatus'];
        $midcutStatus = $categoryTotal['midcutStatus'];
        $data['final']['count']['total']++;
        $data['midcut']['count']['total']++;
        switch($finalStatus) {
            case 'overdue':
                $data['final']['count']['overdue']++;
                break;
            case 'na':
                $data['final']['count']['na']++;
                break;
            case 'pending':
                $data['final']['count']['pending']++;
                break;
            case 'exempted':
                $data['final']['count']['exempted']++;
                break;
            case 'normal':
                $data['final']['count']['normal']++;
                $data['final']['weightSum'] += $categoryWeight;
                $data['final']['grades'][] = array(
                    'rate' => $categoryTotal['finalRate'],
                    'weight' => $categoryWeight
                );
                break;
        }
        switch($midcutStatus) {
            case 'overdue':
                $data['midcut']['count']['overdue']++;
                break;
            case 'na':
                $data['midcut']['count']['na']++;
                break;
            case 'pending':
                $data['midcut']['count']['pending']++;
                break;
            case 'exempted':
                $data['midcut']['count']['exempted']++;
                break;
            case 'normal':
                $data['midcut']['count']['normal']++;
                $data['midcut']['weightSum'] += $categoryWeight;
                $data['midcut']['grades'][] = array(
                    'rate' => $categoryTotal['midcutRate'],
                    'weight' => $categoryWeight
                );
                break;
        }
    }
    $data['midcut']['status'] = getStudentFinalGradeStatusV3($data['midcut']['count']);
    $data['final']['status'] = getStudentFinalGradeStatusV3($data['final']['count']);
    $data['midcut']['rate'] = getStudentFinalGradeRateV3($data['midcut']);
    $data['final']['rate'] = getStudentFinalGradeRateV3($data['final']);
    return $data;
}

function getStudentFinalGradeStatusV3(&$count) {
    if($count['overdue'] > 0) {
        return 'overdue';
    } else {
        if($count['exempted'] == $count['total']) {
            return 'exempted';
        } else {
            if($count['pending'] == $count['total']) {
                return 'pending';
            } else {
                if($count['normal'] == 0) {
                    return 'na';
                } else {
                    return 'normal';
                }
            }
        }
    }
}

function getStudentFinalGradeRateV3(&$data) {
    $status = $data['status'];
    if($status == 'normal') {
        $weightScale = 1 / $data['weightSum'];
        $rate = 0;
        foreach($data['grades'] as $grade) {
            $rate += $grade['rate'] * $grade['weight'] * $weightScale;
        }
        return $rate;
    }
    return null;
}

function getStudentFinalGradesV3(&$categoryMap, &$studentGradeTotals) {
    $studentFinalGrades = array();
    foreach($studentGradeTotals as $studentId => $categoryTotals) {
        $data = getStudentFinalGradeDataV3($categoryTotals, $categoryMap);
        $studentFinalGrades[$studentId]['midcutStatus'] = $data['midcut']['status'];
        $studentFinalGrades[$studentId]['midcutRate'] = $data['midcut']['rate'];
        $studentFinalGrades[$studentId]['finalStatus'] = $data['final']['status'];
        $studentFinalGrades[$studentId]['finalRate'] = $data['final']['rate'];
    }
    return $studentFinalGrades;
}

function getItemAveragesV3(&$studentGrades) {
    $itemAverages = array();
    foreach($studentGrades as $studentId => $categoryGrades) {
        foreach($categoryGrades as $categoryId => $itemGrades) {
            foreach($itemGrades as $itemId => $grade) {
                $status = $grade['status'];
                $itemAverages[$categoryId][$itemId]['totalCount']++;
                switch($status) {
                    case 'normal':
                        $itemAverages[$categoryId][$itemId]['sumScore'] += $grade['scorePoint'];
                        $itemAverages[$categoryId][$itemId]['sumOutOf'] += $grade['maxValue'];
                        $itemAverages[$categoryId][$itemId]['count']++;
                        break;
                    case 'na':
                        $itemAverages[$categoryId][$itemId]['naCount']++;
                        break;
                    case 'overdue':
                        $itemAverages[$categoryId][$itemId]['overdueCount']++;
                        break;
                    case 'pending':
                        $itemAverages[$categoryId][$itemId]['pendingCount']++;
                        break;
                    case 'exempted':
                        $itemAverages[$categoryId][$itemId]['exemptedCount']++;
                        break;
                }
            } // end of foreach:$itemGrades
        }
    }
    foreach($itemAverages as $categoryId => $categoryAverages) {
        foreach($categoryAverages as $itemId => $averages) {
            //$totalCount = $averages['totalCount'];
            $overdueCount = $averages['overdueCount'];
            //$pendingCount = $averages['pendingCount'];
            //$exemptedCount = $averages['pendingCount'];
            $count = $averages['count'];
            $sumScore = $averages['sumScore'];
            $sumOutOf = $averages['sumOutOf'];
            $status = 'normal';
            if($overdueCount > 0) {
                $status = 'overdue';
            }
            if($status == 'normal') {
                if($sumOutOf > 0 && $count > 0) {
                    $itemAverages[$categoryId][$itemId]['averageRate'] = $sumScore / $sumOutOf;
                    $itemAverages[$categoryId][$itemId]['averageScore'] = $sumScore / $count;
                } else {
                    $status = 'pending';
                }
            }
            $itemAverages[$categoryId][$itemId]['status'] = $status;
        }
    }
    return $itemAverages;
}

/**
 * @param array $itemGrades
 * @return array
 * $itemGrades as $itemId => $grade
 */
function getStudentGradeTotalDataV3(&$itemGrades) {
    $data = array(
        'final' => array(
            'count' => array(
                'total' => 0,
                'pending' => 0,
                'overdue' => 0,
                'exempted' => 0,
                'na' => 0,
                'normal' => 0,
            ),
            'status' => '',
            'weightSum' => 0,
        ),
        'midcut' => array(
            'count' => array(
                'total' => 0,
                'pending' => 0,
                'overdue' => 0,
                'exempted' => 0,
                'na' => 0,
                'normal' => 0,
            ),
            'status' => '',
            'weightSum' => 0,
        ),
    );
    foreach($itemGrades as $itemId => $grade) {
        $status = $grade['status'];
        $beforeMidcut = $grade['beforeMidCut'];
        $data['final']['count']['total']++;
        if($beforeMidcut) $data['midcut']['count']['total']++;
        switch($status) {
            case 'pending';
                $data['final']['count']['pending']++;
                if($beforeMidcut) $data['midcut']['count']['pending']++;
                break;
            case 'overdue';
                $data['final']['count']['overdue']++;
                if($beforeMidcut) $data['midcut']['count']['overdue']++;
                break;
            case 'exempted';
                $data['final']['count']['exempted']++;
                if($beforeMidcut) $data['midcut']['count']['exempted']++;
                break;
            case 'na':
                $data['final']['count']['na']++;
                if($beforeMidcut) $data['midcut']['count']['na']++;
                break;
            case 'normal':
                $data['final']['count']['normal']++;
                $data['final']['weightSum'] += $grade['weight'];
                $data['final']['grades'][] = array(
                    'scoreRate' => $grade['scoreRate'],
                    'weight' => $grade['weight'],
                );
                if($beforeMidcut) {
                    $data['midcut']['count']['normal']++;
                    $data['midcut']['weightSum'] += $grade['weight'];
                    $data['midcut']['grades'][] = array(
                        'scoreRate' => $grade['scoreRate'],
                        'weight' => $grade['weight'],
                    );
                }
                break;
        }
    }
    $data['midcut']['status'] = getStudentGradeTotalStatusV3($data['midcut']['count']);
    $data['final']['status'] = getStudentGradeTotalStatusV3($data['final']['count']);
    $data['midcut']['rate'] = getStudentGradeTotalRateV3($data['midcut']);
    $data['final']['rate'] = getStudentGradeTotalRateV3($data['final']);
    return $data;
}

/**
 * @param array $count grade counts
 * @return string
 * @see getStudentGradeTotalDataV3()
 */
function getStudentGradeTotalStatusV3(&$count) {
    if($count['total'] > 0 && $count['exempted'] == $count['total']) {
        // all exempted
        return 'exempted';
    } else {
        if($count['overdue'] > 0) {
            return 'overdue';
        } else {
            if($count['pending'] == $count['total']) {
                return 'pending';
            } else {
                if($count['na'] == $count['total']) {
                    return 'na';
                } else if($count['na'] + $count['pending'] == $count['total']) {
                    return 'pending';
                } else {
                    return 'normal';
                }
            }
        }
    }
}

function getStudentGradeTotalRateV3(&$data) {
    $status = $data['status'];
    if($status == 'normal') {
        $weightScale = 1 / $data['weightSum'];
        $rate = 0;
        foreach($data['grades'] as $grade) {
            $rate += $grade['scoreRate'] * $grade['weight'] * $weightScale;
        }
        return $rate;
    }
    return null;
}

function getStudentGradeTotalsV3(&$studentGrades) {
    $studentGradeTotals = array();
    foreach($studentGrades as $studentId => $categoryGrades) {
        foreach($categoryGrades as $categoryId => $itemGrades) {
            if(!$categoryId) continue;
            $data = getStudentGradeTotalDataV3($itemGrades);
            $studentGradeTotals[$studentId][$categoryId]['midcutRate'] = $data['midcut']['rate'];
            $studentGradeTotals[$studentId][$categoryId]['midcutStatus'] = $data['midcut']['status'];
            $studentGradeTotals[$studentId][$categoryId]['finalRate'] = $data['final']['rate'];
            $studentGradeTotals[$studentId][$categoryId]['finalStatus'] = $data['final']['status'];
        }
    }
    return $studentGradeTotals;
}


/**
 * Initializes item grade for calculation from raw data
 *
 * @param string $today 'yyyy-mm-dd'
 * @param string $midCutoffDate 'yyyy-mm-dd'
 * @param array $item item data
 * @param array $grade grade data or null if not exists
 * @return array
 */
function initializeStudentGradeV3($today, $midCutoffDate, &$item, &$grade) {
    // $assignDate = substr($item['AssignDate'], 0, 10);
    $assignDate = $item['AssignDate'];
    $overdueDate = date('Y-m-d', strtotime($assignDate. ' + 3 days'));
    $beforeMidcut = $assignDate <= $midCutoffDate && $assignDate > '1999-01-01';
    $gradeId = $grade ? $grade['GradeID'] : null;
    $exempted = $grade ? $grade['Exempted'] == '1' : false;
    $scorePoint = $grade ? $grade['ScorePoint'] : null;
    $scoreRate = null;
    $maxValue = floatval($item['MaxValue']);
/* this part should be fixed need to find new way to check if its number */
    if(is_numeric($scorePoint)) {
      // if (filter_var($scorePoint, FILTER_VALIDATE_INT, $options) !== FALSE) {
        // grade data entry DOES exist
        $status = $exempted ? 'exempted' : 'normal';
        $scorePoint = floatval($scorePoint);
        if($maxValue) {
          $scoreRate = $scorePoint / $maxValue;
        } else {
          $scoreRate = null;
        }
        $overdue = false;
    } else {
        // grade data entry NOT exists, OR score NOT entered
        if($exempted) {
            $overdue = false;
            $status = 'exempted';
        } else {
            if($assignDate == '1900-01-01') {
                $overdue = false;
                $status = 'na';
            } else {
                $overdue = $overdueDate < $today;
                $status = $overdue ? 'overdue' : 'pending';
            }
        }
    }
    return array(
        'status' => $status,
        'itemId' => $item['CategoryItemID'],
        'gradeId' => $gradeId,
        'scorePoint' => $scorePoint,
        'scoreRate' => $scoreRate,
        'maxValue' => $maxValue,
        'exempted' => $exempted,
        'overdue' => $overdue,
        'beforeMidCut' => $beforeMidcut,
        'weight' => floatval($item['ItemWeight']),
        'label' => $status,
        'comment' => $grade['Comment'],
        'assignDate' => $assignDate,
        'overdueDate' => $overdueDate,
    );
}

function getStudentGradesV3($midCutoffDate, &$students, &$items, &$grades) {
    $studentGrades = array();
    $today = date('Y-m-d');

    // foreach($students as $studentId => $student) {
    //     foreach($items as $categoryId => $categoryItems) {
    //         foreach($categoryItems as $itemId => $item) {
    //             if(!$itemId) { continue; }
    //             $grade = null;
    //             $studentGrades[$studentId][$categoryId][$itemId] = initializeStudentGradeV3($today, $midCutoffDate, $item, $grade);
    //         }
    //     }
    // }

    for($i=0; $i < sizeof($students); $i++){
      foreach($items as $categoryId => $categoryItems) {
          foreach($categoryItems as $itemId => $item) {
              if(!$itemId) { continue; }
              $grade = null;
              $studentGrades[$students[$i]['StudentID']][$categoryId][$itemId] = initializeStudentGradeV3($today, $midCutoffDate, $item, $grade);
          }
      }
    }



    /** this part should be fixed with PHP 7.2 **/
    foreach($grades as $grade) {
        $studentId = $grade['StudentID'];
        $categoryId = $grade['CategoryID'];
        $itemId = $grade['CategoryItemID'];
        $item = $items[$categoryId][$itemId];
        $studentGrades[$studentId][$categoryId][$itemId] = initializeStudentGradeV3($today, $midCutoffDate, $item, $grade);
    }
    return $studentGrades;
}

function getViewGradeTableRowV3($categoryId, $categoryWeight, &$student, &$items, &$studentGrades, &$studentGradeTotals) {
    $studentId = $student['StudentID'];
    $gradeTotal = $studentGradeTotals[$studentId][$categoryId];
    $midcutStatus = $gradeTotal['midcutStatus'];
    $finalStatus = $gradeTotal['finalStatus'];
    if($midcutStatus == 'normal') {
        $midcutRate = $gradeTotal['midcutRate'];
        $midcutWeightRate = $midcutRate * $categoryWeight;
        $midcutRow = array(
            'status' => 'normal',
            'rate' => $midcutRate,
            'label' => number_format($midcutRate*100, 2).'%',
        );
        $midcutWeightRow = array(
            'status' => 'normal',
            'rate' => $midcutWeightRate,
            'label' => number_format($midcutWeightRate*100, 2).'%',
        );
    } else {
        $midcutRow = array('status'=>$midcutStatus,'label'=>$midcutStatus);
        $midcutWeightRow = array('status'=>$midcutStatus,'label'=>$midcutStatus);
    }
    if($finalStatus == 'normal') {
        $finalRate = $gradeTotal['finalRate'];
        $finalWeightRate = $finalRate * $categoryWeight;
        $finalRow = array(
            'status' => 'normal',
            'rate' => $finalRate,
            'label' => number_format($finalRate*100, 2).'%',
        );
        $finalWeightRow = array(
            'status' => 'normal',
            'rate' => $finalWeightRate,
            'label' => number_format($finalWeightRate*100, 2).'%',
        );
    } else {
        $finalRow = array('status'=>$finalStatus,'label'=>$finalStatus);
        $finalWeightRow = array('status'=>$finalStatus,'label'=>$finalStatus);
    }
    $row = array();
    $row[] = $student['StudentID'];
    $row[] = $student['LastName'];
    $row[] = $student['FirstName'];
    $row[] = $student['EnglishName'];
    $row[] = $midcutRow;
    $row[] = $midcutWeightRow;
    $row[] = $finalRow;
    $row[] = $finalWeightRow;
    foreach($items as $item) {
        $itemId = $item['CategoryItemID'];
        $AssignDate = $item['AssignDate'];
        $grade = $studentGrades[$studentId][$categoryId][$itemId];
        $status = $grade['status'];
        if($status == 'normal') {
            $score = $grade['scorePoint'];
            $row[] = array(
                'status' => $status,
                'rate' => $score,
                'id' => $itemId,
                'label' => number_format($score, 2),
            );
        } else {
          if($status) {
            $row[] = array('status'=>$status,'id' => $itemId);
          } else {
            if($$AssignDate < date('Y-m-d')){
              $row[] = array('status'=>'overdue','id' => $itemId, 'AssignDate' => $AssignDate);
            } else {
              $row[] = array('status'=>'pending','id' => $itemId, 'AssignDate' => $AssignDate);
            }
          }
        }
    }
    // for ($i=0; $i < sizeof($items) ; $i++) {
    //   $itemId = $items[$i]['CategoryItemID'];
    //   $AssignDate = $items[$i]['AssignDate'];
    //   $grade = $studentGrades[$studentId][$categoryId][$itemId];
    //   $status = $grade['status'];
    //   if($status == 'normal') {
    //       $score = $grade['scorePoint'];
    //       $row[] = array(
    //           'status' => $status,
    //           'rate' => $score,
    //           'id' => $itemId,
    //           'label' => number_format($score, 2),
    //       );
    //   } else {
    //     if($status) {
    //       $row[] = array('status'=>$status,'id' => $itemId);
    //     } else {
    //       if($$AssignDate < date('Y-m-d')){
    //         $row[] = array('status'=>'overdue','id' => $itemId, 'AssignDate' => $AssignDate);
    //       } else {
    //         $row[] = array('status'=>'pending','id' => $itemId, 'AssignDate' => $AssignDate);
    //       }
    //     }
    //   }
    // }


    return $row;
}

function getViewGradeTableAverageRowV3(&$categoryRows) {
    $average = array();
    foreach($categoryRows as $categoryId => $rows) {
        $average = array();
        foreach($rows as $row) {
            for($i = 4; $i < count($row); ++$i) {
                $status = $row[$i]['status'];
                $average[$categoryId][$i]['count']++;
                switch($status) {
                    case 'overdue':
                        $average[$categoryId][$i]['overdueCount']++;
                        break;
                    case 'exempted':
                        $average[$categoryId][$i]['exemptedCount']++;
                        break;
                    case 'pending':
                        $average[$categoryId][$i]['pendingCount']++;
                        break;
                    case 'na':
                        $average[$categoryId][$i]['naCount']++;
                        break;
                    case 'normal':
                        $average[$categoryId][$i]['normalCount']++;
                        $average[$categoryId][$i]['sum'] += $row[$i]['rate'];
                        break;
                }
            }
        }
    }
    foreach($average as $categoryId => $row) {
        $averageRow = array('', '', 'Class Average', '');
        for($i = 4; $i < count($row)+4; ++$i) {
            //$count = $average['count'];
            $overdueCount = $row[$i]['overdueCount'];
            $normalCount = $row[$i]['normalCount'];
            $sum = $row[$i]['sum'];
            if($overdueCount > 0) {
                $averageRow[$i]['status'] = 'overdue';
            } else {
                if($normalCount > 0) {
                    $avg = $sum / $normalCount;
                    $averageRow[$i] = array(
                        'status' => 'normal',
                        'rate' => $avg,
                        'label' => number_format($i >= 8 ? $avg : $avg * 100, 2).($i >= 8 ? '' : '%'),
                    );
                } else {
                    $averageRow[$i]['status'] = 'na';
                }
            }
        }
        $categoryRows[$categoryId][] = $averageRow;
    }
}

function getViewGradeTableV3(&$studentGrades, &$categoryMap, &$itemMap, &$studentMap, &$studentGradeTotals, &$tableHeaders, &$categoryItemArr) {
    // $rows = array();
    // foreach($categoryMap as $categoryId => $category) {
    //     $categoryWeight = $category['CategoryWeight'];
    //     $items = $itemMap[$categoryId];
    //     $items = sortItemsV3($items);
    //     $tableHeaders[$categoryId][0] = '';
    //     $tableHeaders[$categoryId][1] = '';
    //     $tableHeaders[$categoryId][2] = '';
    //     $tableHeaders[$categoryId][3] = '';
    //     $tableHeaders[$categoryId][4] = '';
    //     $tableHeaders[$categoryId][5] = '';
    //     $tableHeaders[$categoryId][6] = '';
    //     $tableHeaders[$categoryId][7] = '';
    //     $i = 8;
    //     foreach($items as $item) {
    //         $tableHeaders[$categoryId][$i++] = $item['CategoryItemID'];
    //     }
    //     foreach($studentMap as $studentId => $student) {
    //         $rows[$categoryId][] = getViewGradeTableRowV3($categoryId, $categoryWeight, $student, $items, $studentGrades, $studentGradeTotals);
    //     }
    //     getViewGradeTableAverageRowV3($rows);
    // }
    // return $rows;

    $rows = array();
    foreach($categoryMap as $categoryId => $category) {
        $categoryWeight = $category['CategoryWeight'];
        $items = $categoryItemArr[$categoryId];
        $tableHeaders[$categoryId][0] = '';
        $tableHeaders[$categoryId][1] = '';
        $tableHeaders[$categoryId][2] = '';
        $tableHeaders[$categoryId][3] = '';
        $tableHeaders[$categoryId][4] = '';
        $tableHeaders[$categoryId][5] = '';
        $tableHeaders[$categoryId][6] = '';
        $tableHeaders[$categoryId][7] = '';
        $i = 8;
        for ($s=0; $s < sizeof($items); $s++) {
          $tableHeaders[$categoryId][$i++] = $items[$s]['CategoryItemID'];
        }
        foreach($studentMap as $studentId => $student) {
            $rows[$categoryId][] = getViewGradeTableRowV3($categoryId, $categoryWeight, $student, $items, $studentGrades, $studentGradeTotals);
        }
        getViewGradeTableAverageRowV3($rows);
    }
    return $rows;
}

function getOverviewTableRowV3(&$student, &$items, &$studentGrades) {
    $studentId = $student['StudentID'];
    $row = array();
    $row[] = $student['StudentID'];
    $row[] = $student['LastName'];
    $row[] = $student['FirstName'];
    $row[] = $student['EnglishName'];
    foreach($items as $item) {
        $categoryId = $item['CategoryID'];
        $itemId = $item['CategoryItemID'];
        $grade = $studentGrades[$studentId][$categoryId][$itemId];
        $status = $grade['status'];
        if($status == 'normal') {
            $score = $grade['scorePoint'];
            $maxValue = $grade['maxValue'];
            $number = number_format($score, 2);
            $percent = number_format($score / $maxValue * 100, 2);
            $label = "{$number} ({$percent}%)";
            $row[] = array(
                'status' => $status,
                'score' => $score,
                'rate' => $score / $maxValue,
                'label' => $label,
            );
        } else {
            $row[] = array(
                'status' => $status,
                'label' => $status
            );
        }
    }
    return $row;
}

function getOverviewTableAverageRowV3(&$rows) {
    $average = array();
    foreach($rows as $row) {
        for($i = 4; $i < count($row); ++$i) {
            $status = $row[$i]['status'];
            $average[$i]['count']++;
            switch($status) {
                case 'overdue':
                    $average[$i]['overdueCount']++;
                    break;
                case 'exempted':
                    $average[$i]['exemptedCount']++;
                    break;
                case 'pending':
                    $average[$i]['pendingCount']++;
                    break;
                case 'na':
                    $average[$i]['naCount']++;
                    break;
                case 'normal':
                    $average[$i]['normalCount']++;
                    $average[$i]['sumRate'] += $row[$i]['rate'];
                    $average[$i]['sumScore'] += $row[$i]['score'];
                    break;
            }
        }
    }
    $averageRow = array('', '', 'Class Average', '');
    for($i = 4; $i < count($average)+4; ++$i) {
        //$count = $average['count'];
        $overdueCount = $average[$i]['overdueCount'];
        $normalCount = $average[$i]['normalCount'];
        $sumRate = $average[$i]['sumRate'];
        $sumScore = $average[$i]['sumScore'];
        if($overdueCount > 0) {
            $averageRow[$i]['status'] = 'overdue';
        } else {
            if($normalCount > 0) {
                $avgRate = $sumRate / $normalCount;
                $avgScore = $sumScore / $normalCount;
                $averageRow[$i] = array(
                    'status' => 'normal',
                    'rate' => $avgRate,
                    'score' => $avgScore,
                    'label' => number_format($avgScore, 2).' ('.number_format($avgRate*100,2).'%)',
                );
            } else {
                $averageRow[$i]['status'] = 'na';
            }
        }
    }
    $rows[] = $averageRow;
}

function getOverviewTableV3($courseId, &$studentGrades, &$termItemArray, &$studentMap, &$tableHeaders) {
    $rows = array();
    $items = array();
    foreach($termItemArray as $item) {
        if($item['SubjectID'] == $courseId) {
            $items[] = $item;
        }
    }
    $items = sortItemsV3($items);
    $tableHeaders[0] = '';
    $tableHeaders[1] = '';
    $tableHeaders[2] = '';
    $tableHeaders[3] = '';
    $i = 4;
    foreach($items as $item) {
        $tableHeaders[$i++] = $item['CategoryItemID'];
    }
    foreach($studentMap as $studentId => $student) {
        $rows[] = getOverviewTableRowV3($student, $items, $studentGrades);
    }
    getOverviewTableAverageRowV3($rows);
    return $rows;
}

/**
 * Converts rate(0~1) into letter
 * @param number $rate 0 ~ 1
 * @return string grade letter
 */
function getGradeLetterV3($rate) {
    $rate *= 100;
    if($rate >= 86) {
        return 'A';
    } else if($rate >= 73 && $rate < 86) {
        return 'B';
    } else if($rate >= 67 && $rate < 73) {
        return 'C+';
    } else if($rate >= 60 && $rate < 67) {
        return 'C';
    } else if($rate >= 50 && $rate < 60) {
        return 'C-';
    } else {
        return 'F';
    }
}

function getTermStatus($term) {
    $today = date('Y-m-d H:i:s');
    $start = substr($term['StartDate'], 0, 10);
    $end = substr($term['EndDate'], 0, 10);
    $mid = substr($term['MidCutOffDate'], 0, 10);
    if($today < $start) {
        return 'Term Not Started';
    } else if($today >= $start && $today <= $mid) {
        return 'Midterm In Progress';
    } else if($today > $mid && $today <= $end) {
        return 'Final In Progress';
    } else {
        return 'Term Ended';
    }
}

function getOverallAverageTableRowV3(&$categoryMap, &$student, &$studentGradeTotals, &$studentFinalGrades) {
    $studentId = $student['StudentID'];
    $row = array();
    $row[] = $student['StudentID'];
    $row[] = $student['LastName'];
    $row[] = $student['FirstName'];
    $row[] = $student['EnglishName'];

    $finalGrade = $studentFinalGrades[$studentId];

    if($finalGrade['midcutStatus'] == 'normal') {
        $row[] = array(
            'status' => 'normal',
            'rate' => $finalGrade['midcutRate'],
            'label' => number_format($finalGrade['midcutRate']*100,2).'%',
        );
        $row[] = array(
            'status'=>'normal',
            'rate'=>$finalGrade['midcutRate'],
            'label' => getGradeLetterV3($finalGrade['midcutRate']),
        );
    } else {
        $row[] = array('status'=>$finalGrade['midcutStatus']);
        $row[] = array('status'=>$finalGrade['midcutStatus']);
    }

    if($finalGrade['finalStatus'] == 'normal') {
        $row[] = array(
            'status' => 'normal',
            'rate' => $finalGrade['finalRate'],
            'label' => number_format($finalGrade['finalRate']*100,2).'%',
        );
        $row[] = array(
            'status'=>'normal',
            'rate'=>$finalGrade['finalRate'],
            'label' => getGradeLetterV3($finalGrade['finalRate']),
        );
    } else {
        $row[] = array('status'=>$finalGrade['finalStatus']);
        $row[] = array('status'=>$finalGrade['finalStatus']);
    }

    foreach($categoryMap as $categoryId => $category) {
        $categoryWeight = (float)$category['CategoryWeight'];
        $gradeTotal = $studentGradeTotals[$studentId][$categoryId];
        $finalStatus = $gradeTotal['finalStatus'];
        $midcutStatus = $gradeTotal['midcutStatus'];
        $r = array(
            'categoryId' => $categoryId,
            'categoryName' => $category['Text'],
        );
        if($finalStatus == 'normal') {
            $finalRate = $gradeTotal['finalRate'];
            $r['status'] = $finalStatus;
            $r['rate'] = $finalRate * $categoryWeight;
            $r['rate100'] = $finalRate;
            $r['label'] = number_format($r['rate'] * 100, 2).'%';
            $r['finalStatus'] = $finalStatus;
            $r['finalRate'] = $finalRate * $categoryWeight;
            $r['finalLabel'] = number_format($r['finalRate'] * 100, 2).'%';
        } else {
            $r['status'] = $finalStatus;
            $r['finalStatus'] = $finalStatus;
        }
        if($midcutStatus == 'normal') {
            $midcutRate = $gradeTotal['midcutRate'];
            $r['midcutStatus'] = $midcutStatus;
            $r['midcutRate100'] = $midcutRate;
            $r['midcutRate'] = $midcutRate * $categoryWeight;
            $r['midcutLabel'] = number_format($r['midcutRate'] * 100, 2).'%';
        } else {
            $r['midcutStatus'] = $midcutStatus;
        }
        $row[] = $r;
    }
    return $row;
}

function getOverallAverageTableAverageRowV3(&$rows) {
    $average = array();
    foreach($rows as $row) {
        for($i = 4; $i < count($row); ++$i) {
            $status = $row[$i]['status'];
            $average[$i]['count']++;
            switch($status) {
                case 'overdue':
                    $average[$i]['overdueCount']++;
                    break;
                case 'exempted':
                    $average[$i]['exemptedCount']++;
                    break;
                case 'pending':
                    $average[$i]['pendingCount']++;
                    break;
                case 'na':
                    $average[$i]['naCount']++;
                    break;
                case 'normal':
                    $average[$i]['normalCount']++;
                    $average[$i]['sumRate'] += $row[$i]['rate'];
                    break;
            }
        }
    }
    $averageRow = array('', '', 'Class Average', '');
    for($i = 4; $i < count($average)+4; ++$i) {
        //$count = $average['count'];
        $overdueCount = $average[$i]['overdueCount'];
        $normalCount = $average[$i]['normalCount'];
        $sumRate = $average[$i]['sumRate'];
        if($overdueCount > 0) {
            $averageRow[$i]['status'] = 'overdue';
        } else {
            if($normalCount > 0) {
                $avgRate = $sumRate / $normalCount;
                if($i == 5 || $i == 7) {
                    $label = getGradeLetterV3($avgRate);
                } else {
                    $label = number_format($avgRate*100,2).'%';
                }
                $averageRow[$i] = array(
                    'status' => 'normal',
                    'rate' => $avgRate,
                    'label' => $label,
                );
            } else {
                $averageRow[$i]['status'] = 'na';
            }
        }
    }
    $rows[] = $averageRow;
}

function getOverallAverageTableV3(&$categoryMap, &$studentMap, &$studentGradeTotals, &$studentFinalGrades) {
    $rows = array();
    foreach($studentMap as $studentId => $student) {
        $rows[] = getOverallAverageTableRowV3($categoryMap, $student, $studentGradeTotals, $studentFinalGrades);
    }
    getOverallAverageTableAverageRowV3($rows);
    return $rows;
}

function sortItemsV3(&$items) {
    $res = array();
    $na = array();
    foreach($items as $item) {
        $assignDate = $item['AssignDate'];
        $notAssigned = $assignDate == '1900-01-01';
        if($notAssigned) {
            $na[] = $item;
        } else {
            $res[] = $item;
        }
    }
    return array_merge($res, $na);
}
function getGradeDataV3($termId, $midCutoff, $courseId, $grades, &$categoryMap, &$itemMap, &$studentMap, &$termItemArray, &$categoryItemArr) {
    $overviewTableHeader = array();
    $viewGradeTableHeader = array();
    $midCutoffDate = substr($midCutoff, 0, 10);
    $studentMap2 = $studentMap;

    $studentGrades[$courseId] = getStudentGradesV3($midCutoffDate, $studentMap2, $itemMap[$courseId], $grades);;
    $studentGradeTotals[$courseId] = getStudentGradeTotalsV3($studentGrades[$courseId]);
    $studentFinalGrades = getStudentFinalGradesV3($categoryMap, $studentGradeTotals[$courseId]);
    $itemAverages = getItemAveragesV3($studentGrades[$courseId]);
    $viewGradeTable = getViewGradeTableV3($studentGrades[$courseId], $categoryMap, $itemMap[$courseId], $studentMap, $studentGradeTotals[$courseId], $viewGradeTableHeader, $categoryItemArr);
    $overviewTable[$courseId] = getOverviewTableV3($courseId, $studentGrades[$courseId], $termItemArray, $studentMap, $overviewTableHeader[$courseId]);
    $overallAverageTable[$courseId] = getOverallAverageTableV3($categoryMap, $studentMap, $studentGradeTotals[$courseId], $studentFinalGrades);



    $itemMap2 = sortItemsV3($categoryMap);
    return array(
        'studentGradeTotals' => $studentGradeTotals,
        'viewGradeTable' => $viewGradeTable,
        'viewGradeTableHeader' => $viewGradeTableHeader,
        'overviewTable' => $overviewTable,
        'overviewTableHeader' => $overviewTableHeader,
        'overallAverageTable' => $overallAverageTable,
        'grades' => $studentGrades,
        'final' => $studentFinalGrades,
        'test' => $categoryItemArr
    );
}
