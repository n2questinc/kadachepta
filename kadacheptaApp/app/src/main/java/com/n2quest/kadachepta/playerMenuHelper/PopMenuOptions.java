package com.n2quest.kadachepta.playerMenuHelper;

/**
 * Created by n2quest on 15/08/16.
 */

public class PopMenuOptions {

    public final String description;
    public final String amount;

    public PopMenuOptions(String amount, String description) {
        this.amount = amount;
        this.description = description;
    }

    @Override
    public String toString() {
        return "DonationOption{" +
                "description='" + description + '\'' +
                ", amount='" + amount + '\'' +
                '}';
    }
}