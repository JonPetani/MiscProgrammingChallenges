/*
Programmer: Jonathan Petani
Date: 4/29/2021
Purpose: User inputs two arrays that are sorted by system, then they are merged, sorted, and the median is calculated. User can elect to do it again if they wish.
*/
import java.util.Scanner;
public class median {
	public static void main(String[] args) {
		//  main variables and objects
		double[] arr1;
		double[] arr2;
		double[] merge;
		char cont = 'y';
		double median = 0.0;
		int size = 0;
		Scanner stdin = new Scanner(System.in);
		do {
			System.out.println("This Code Will Find The Median of Two Sorted Arrays (Sizes and Elements Defined by User) Merged.");
			System.out.print("How big should array one be? Size must be bigger than 0: ");
			size = stdin.nextInt();
			//size check
			if(size <= 0) {
				System.out.println("Size given is 0 or below. Try again.");
				continue;
			}
			arr1 = makeSortedArray(size).clone();
			printArray(arr1);
			System.out.print("\nHow big should array two be? Size must be bigger than 0: ");
			size = stdin.nextInt();
			//size check
			if(size <= 0) {
				System.out.println("Size given is 0 or below. Try again.");
				continue;
			}
			arr2 = makeSortedArray(size).clone();
			printArray(arr2);
			merge = mergeArrays(arr1, arr2).clone();
			System.out.println("\nThe two arrays merged then sorted.");
			printArray(merge);
			median = findMedian(merge);
			System.out.println("\nThe Median of this merged Array is: " + median);
			//choice to do process again
			System.out.print("Would you like to try again? If so, enter Y or y. Otherwise, enter another character: ");
			cont = stdin.next().charAt(0);
		}while(cont == 'y' || cont == 'Y');
	}
	//Determines Array Contents by User Input and Sorts The Array
	public static double[] makeSortedArray(int size) {
		double[] sorted = new double[size];
		Scanner element = new Scanner(System.in);
		//user inputs the array elements for the input array
		System.out.println("Now define the elements inside this array.");
		for(int i = 0; i < sorted.length; i++) {
			System.out.print("Enter element for index" + i + ": ");
			sorted[i] = element.nextDouble();
		}
		//bubble sort
		double temp = 0.0;
		for(int i = 0; i < sorted.length - 1; i++) {
			for(int j = 0; j < sorted.length - i - 1; j++) {
				if(sorted[j] > sorted[j + 1]) {
					temp = sorted[j];
					sorted[j] = sorted[j + 1];
					sorted[j + 1] = temp;
				}
			}
		}
		return sorted;
	}
	//Print The Input Array
	public static void printArray(double[] arr) {
		System.out.print("Array Contents: [ ");
		for(int i = 0; i < arr.length; i++) {
			System.out.print(arr[i] + " ");
		}
		System.out.print("]");
	}
	//Merge The Input Arrays
	public static double[] mergeArrays(double[] arr1, double[] arr2) {
		double[] merged = new double[arr1.length + arr2.length];
		//merge the arr1 elements
		for(int i = 0; i < arr1.length; i++) {
			merged[i] = arr1[i];
		}
		//merge the arr2 elements
		int counter = 0;
		for(int i = arr1.length; i < arr1.length + arr2.length; i++) {
			merged[i] = arr2[counter];
			counter++;
		}
		//bubble sort
		double temp = 0.0;
		for(int i = 0; i < merged.length - 1; i++) {
			for(int j = 0; j < merged.length - i - 1; j++) {
				if(merged[j] > merged[j + 1]) {
					temp = merged[j];
					merged[j] = merged[j + 1];
					merged[j + 1] = temp;
				}
			}
		}
		return merged;
	}
	public static double findMedian(double[] arr) {
		int center;
		//if array has even size
		if(arr.length % 2 == 0) {
			center = arr.length / 2;
			return (arr[center] + arr[center - 1]) / 2;
		}
		//if array has odd size
		else
			return arr[arr.length / 2];
	}
}