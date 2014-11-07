package com.gang.comms;

public class StringHelper
{
    public static boolean isNotBlank(String Pattern)
    {
        return (Pattern != null) && !"".equals(Pattern);
    } // end isNotBlank()

    public static boolean isBlank(String Pattern)
    {
        return (Pattern == null) || "".equals(Pattern);
    } // end isBlank()

    public static String getString(
        Object o,
        Boolean isInteger)
    {
        if (isInteger)
        {
            return (o == null) ? "0" : o.toString();
        } // end if
        else
        {
            return (o == null) ? "" : o.toString();
        } // end else
    } // end getString()
} // end StringHelper
