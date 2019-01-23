<?php 

class Statistic
{
    /**
     * Count of distinct url per domain      
     * 
     * @return $count
     */ 
    public static function CountUrlDomain($conn, $id=0)
    {
        // prepare and bind
        $stmt = $conn->prepare("SELECT count(distinct url_id) FROM tbRequest WHERE domain_id = ?");

        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            exit($stmt->error);
        } else {
            /* bind result variables */
            $stmt->bind_result($count);
            /* fetch value */
            $stmt->fetch();
        }

        $stmt->close();

        return $count === null ? 0 : $count;
    }

    
    /**
     * Count of distinct url per domain      
     * 
     * @return $count
     */ 
    public static function AverageTimeDomain($conn, $id=0)
    {
        // prepare and bind
        $stmt = $conn->prepare("SELECT avg(duration_mls)FROM tbRequest WHERE domain_id = ? AND request_time >date_sub(now(), interval 24 hour)");

        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            exit($stmt->error);
        } else {
            $stmt->bind_result($avg_duration_mls);
            /* fetch value */
            $stmt->fetch();
        }

        $stmt->close();

        return $avg_duration_mls === null ? 0 : round($avg_duration_mls);
    }

    /**
     * Total count of the element for domain    
     * 
     * @return $count
     */ 
    public static function TotalElementDomain($conn, $domain_id, $element_id)
    {

        // sql query formatting
        $sql = sprintf("select sum(count_elm) from tbRequest join (SELECT url_id,domain_id, element_id, max(request_time) as request_time FROM tbRequest group by url_id, domain_id, element_id) a on tbRequest.url_id = a.url_id and tbRequest.domain_id = a.domain_id and tbRequest.element_id = a.element_id and tbRequest.request_time = a.request_time where tbRequest.domain_id = ? AND tbRequest.element_id = ?");

        // prepare and bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $domain_id, $element_id);

        if (!$stmt->execute()) {
            exit($stmt->error);
        } else {
            $stmt->bind_result($count);
            $stmt->fetch();
        }

        $stmt->close();

        return $count === null ? 0 : $count;
    }
    
    /**
     * // Total count of the element for All requests    
     * 
     * @return $count
     */ 
    public static function TotalCountElement($conn, $element_id)
    {
        // prepare and bind
        $stmt = $conn->prepare("SELECT sum(count_elm) FROM tbRequest WHERE element_id = ?");

        $stmt->bind_param("i", $element_id);
        
        if (!$stmt->execute()) {
            exit($stmt->error);
        } else {
            /* bind result variables */
            $stmt->bind_result($count);
            /* fetch value */
            $stmt->fetch();
        }

        $stmt->close();

        return $count === null ? 0 : $count;
    }
}